import { Component } from "react";
import { connect } from "react-redux";

import GraphParentBox from "./GraphParentBox";
import NewsInfoBox from "./NewsInfoBox";

class GraphNewsBox extends Component{
	constructor(props){
		super(props);
	}

	render(){
		return (<div className="graph-news-box">
			<NewsInfoBox/>
			<GraphParentBox/>
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(GraphNewsBox);