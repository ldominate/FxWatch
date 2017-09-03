import { Component } from "react";
import { connect } from "react-redux";

import GraphNewsBox from "./GraphNewsBox";

class MainBox extends Component{
	constructor(props){
		super(props);
	}

	render(){
		return (<div className="graph-box">
			<GraphNewsBox/>
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(MainBox);