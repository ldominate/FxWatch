import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxScrollView from "devextreme/ui/scroll_view";

import GraphBox from "./GraphBox";

import { reachNewsCategory } from "../actions/ActionsWidget";

class MainBox extends Component{
	constructor(props){
		super(props);
		this.scrollView = null;
		this.endCategory = false;
		this.newsId = null;
	}
	shouldComponentUpdate(nextProps, nextState) {
		// if(!nextProps.newsList.selectFirst){
		//console.log(nextProps.endCategory);
		//console.log(this.endCategory);
		const newsId = nextProps.graphKeys.getIn([0, "news", "id"]);
		this.scrollView.dxScrollView("instance").release();
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
			//this.scrollView.dxScrollView("instance").release(true);
			// this.scrollView.dxScrollView("instance").release(false);
			this.newsId = newsId;
		}
		// }
		//console.log(nextProps.graphKeys);
		return true;
	}
	componentDidMount() {
		this.endCategory = this.props.endCategory;
		this.newsId = this.props.graphKeys.getIn([0, "news", "id"]);
		//console.log(this.props.graphKeys);
		this.scrollView = $(ReactDOM.findDOMNode(this));
		this.scrollView.dxScrollView({
			scrollByThumb: true,
			direction: 'vertical',
			reachBottomText: "Загрузка...",
			//useNative: true,
			onReachBottom: this.reachBottom.bind(this)
		}).dxScrollView("instance");
	}
	reachBottom(args, eventName){
		//console.log(args);
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
		endCategory: state.get("endCategory"),
		graphKeys: state.get("graphs"),
		newsList: state.get("newsList").toJSON()
	}
};

const mapDispatchToProps = (dispatch) => ({
	reachNewsCategory: () => dispatch(reachNewsCategory())
});

export default connect(mapStateToProps, mapDispatchToProps)(MainBox);