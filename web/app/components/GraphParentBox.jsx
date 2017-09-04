import { Component } from "react";
import { connect } from "react-redux";

import CandleStickBox from "./CandleStickBox";

class GraphParentBox extends Component{
	constructor(props){
		super(props);
	}

	render(){
		return (<div className="graph-parent">
			<CandleStickBox side="leftCandle" className="candle-stick-box-left"/>
			<CandleStickBox side="rightCandle" className="candle-stick-box-right"/>
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(GraphParentBox);