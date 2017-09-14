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
	componentDidMount() {
		this.scrollView = $(ReactDOM.findDOMNode(this));
		this.scrollView.dxScrollView({
			scrollByThumb: true,
			direction: 'vertical',
			reachBottomText: "Загрузка...",
			onReachBottom: (args, eventName) => {
				console.log(args);
				args.component.release();
			}
		}).dxScrollView("instance");
	}
	render(){
		return (<div className="graph-scroll-box">
			<GraphBox index={0} />
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(MainBox);