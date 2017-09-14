import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxScrollView from "devextreme/ui/scroll_view";

import GraphBox from "./GraphBox";

class MainBox extends Component{
	constructor(props){
		super(props);
		this.scrollView = null;
	}
	shouldComponentUpdate(nextProps, nextState) {
		if(!nextProps.newsList.selectFirst){
			this.scrollView.dxScrollView("instance").release();
		}
		return true;
	}
	componentDidMount() {
		//console.log(this.props.graphKeys);
		this.scrollView = $(ReactDOM.findDOMNode(this));
		this.scrollView.dxScrollView({
			scrollByThumb: true,
			direction: 'vertical',
			reachBottomText: "Загрузка...",
			//useNative: true,
			onReachBottom: (args, eventName) => {
				console.log(args);
				args.component.release();
			}
		}).dxScrollView("instance");
	}
	render(){
		return (<div className="graph-scroll-box">
			<div>
			{this.props.graphKeys.map((n, k) => {
				// console.log(n);
				// console.log(k);
				return <GraphBox key={k} index={k} />;
			})}
			</div>
		</div>);
	}
}

const mapStateToProps = (state) => ({
	graphKeys: state.get("graphs"),
	newsList: state.get("newsList").toJSON()
});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(MainBox);