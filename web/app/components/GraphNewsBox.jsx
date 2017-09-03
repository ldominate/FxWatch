import { Component } from "react";
import { connect } from "react-redux";

import GraphParentBox from "./GraphParentBox";

class GraphNewsBox extends Component{
	constructor(props){
		super(props);
	}

	render(){
		return (<div className="graph-news-box">
			<div className="news-info-title"></div>
			<GraphParentBox/>
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(GraphNewsBox);