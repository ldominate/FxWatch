import { Component } from "react";
import { connect } from "react-redux";

import GraphNewsBox from "./GraphNewsBox";
import NewsAssociatedBox from "./NewsAssociatedBox";

class GraphBox extends Component{
	render(){
		return (
		<div className="graph-box">
			<GraphNewsBox/>
			<NewsAssociatedBox/>
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(GraphBox);