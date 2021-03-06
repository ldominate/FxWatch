import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import "devextreme/ui/scroll_view";

import GraphBox from "./GraphBox";

import { reachNewsCategory } from "../actions/ActionsWidget";

class MainBox extends Component{
	constructor(props){
		super(props);
		this.scrollView = null;
		this.endCategory = false;
		this.newsId = null;
		this.newNews = false;
		this.skip = null;
		this.inReach = false;
	}
	shouldComponentUpdate(nextProps, nextState) {
		//console.log("nextProps");
		// if(!nextProps.newsList.selectFirst){
		console.log("endCategory", this.endCategory, nextProps.endCategory);
		const newsId = nextProps.graphKeys.getIn([0, "news", "id"]);
		//this.scrollView.dxScrollView("instance").update();


		if(nextProps.endCategory && this.endCategory !== nextProps.endCategory){
			//console.log("set null");
			this.scrollView.dxScrollView("instance").option("onReachBottom", null);
			this.endCategory = nextProps.endCategory;
		}else if(this.endCategory !== nextProps.endCategory){
			//console.log("set reach");
			//this.scrollView.dxScrollView("instance").release(true);
			//this.scrollView.dxScrollView("instance").scrollTop();
			this.scrollView.dxScrollView("instance").option("onReachBottom", this.reachBottom.bind(this));
			//this.scrollView.dxScrollView("instance").refresh();
			//this.scrollView.dxScrollView("instance").release(false);
			this.endCategory = nextProps.endCategory;
		}
		if(this.newsId !== newsId){
			//console.log("set news id");
			//this.scrollView.dxScrollView("instance").scrollTop();
			this.scrollView.dxScrollView("instance").scrollTo(0);
			//this.scrollView.dxScrollView("instance").update();
			//this.scrollView.dxScrollView("instance").refresh();
			// this.scrollView.dxScrollView("instance").release();
			// this.scrollView.dxScrollView("instance").release(false);
			this.newsId = newsId;
			this.newNews = true;
			this.inReach = false;
		}else{
			this.newNews = false;
		}
		// }
		//console.log(nextProps.graphKeys);
		return true;
	}
	componentDidUpdate(prevProps, prevState){
		//console.log("prevProps");
		this.scrollView.dxScrollView("instance").update()
			.done(() => {
				//console.log("done");
				//console.log(this.scrollView.dxScrollView("instance").scrollHeight());
				this.scrollView.dxScrollView("instance").release();
				const scrollHeight = this.scrollView.dxScrollView("instance").scrollHeight();
				const clientHeight = this.scrollView.dxScrollView("instance").clientHeight();
				console.log("scrollHeight:", scrollHeight, "clientHeight:", clientHeight);
				const newsId = this.props.graphKeys.getIn([0, "news", "id"]);
				//console.log(newsId);
				if(!this.inReach && this.newsId > 0 && !this.props.endCategory && scrollHeight <= clientHeight){
					console.log("reach bottom force");
					this.props.reachNewsCategory();
					this.inReach = true;
				}
				if(this.endCategory){
					this.inReach = false;
				}
				if(!this.endCategory && scrollHeight > clientHeight){
					this.scrollView.dxScrollView("instance").option("onReachBottom", this.reachBottom.bind(this));
				}
				console.log("inReach", this.inReach);
				if(scrollHeight < 400 && newsId > 0){
					//console.log("done release");
					this.scrollView.dxScrollView("instance").release()
						.done(() => {
							if(this.skip !== this.props.skip || this.newNews){
								this.scrollView.dxScrollView("instance").scrollTo(1);
								this.skip = this.props.skip;
							}
						});
					//console.log(this.scrollView.dxScrollView("instance").option("onReachBottom"));
					//this.scrollView.dxScrollView("instance").refresh();
				}
			});
		// const scrollHeight = this.scrollView.dxScrollView("instance").scrollHeight();
		// console.log(scrollHeight);
		// const newsId = this.props.graphKeys.getIn([0, "news", "id"]);
		// console.log(newsId);
		// if(scrollHeight < 400 && newsId > 0){
		// 	this.props.reachNewsCategory();
		// }
	}
	componentDidMount() {
		//console.log("did");
		this.endCategory = this.props.endCategory;
		this.newsId = this.props.graphKeys.getIn([0, "news", "id"]);
		this.skip = this.props.skip;
		//console.log(this.props.graphKeys);
		this.scrollView = $(ReactDOM.findDOMNode(this));
		this.scrollView.dxScrollView({
			scrollByContent: true,
			scrollByThumb: true,
			direction: 'vertical',
			reachBottomText: "Загрузка...",
			//bounceEnabled: true,
			useNative: false,
			height: 510,
			//onReachBottom: e => console.log(e)
			onReachBottom: this.reachBottom.bind(this)
		}).dxScrollView("instance");
		if(this.props.graphKeys.size <= 0){
			//console.log("did release");
			this.scrollView.dxScrollView("instance").release(true);
		}
	}
	reachBottom(args, eventName){
		console.log("reach bottom");
		//console.log(args);
		args.component.release();
		this.props.reachNewsCategory();
	}
	render(){
		return <div className="graph-scroll-box">
			<div>
			{this.props.graphKeys.map((n, k) => {
				//console.log(n);
				//console.log(k);
				return <GraphBox key={k} index={k} />;
			})}
			</div>
		</div>;
	}
}

const mapStateToProps = (state) => {
	//console.log(state.toJSON());
	return {
		skip: state.get("skip"),
		endCategory: state.get("endCategory"),
		graphKeys: state.get("graphs"),
		newsList: state.get("newsList").toJSON()
	}
};

const mapDispatchToProps = (dispatch) => ({
	reachNewsCategory: () => dispatch(reachNewsCategory())
});

export default connect(mapStateToProps, mapDispatchToProps)(MainBox);