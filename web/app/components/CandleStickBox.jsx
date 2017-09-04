import { Component } from "react";
import { connect } from "react-redux";

import NewsItemTabs from "./NewsItemTabs";
import CandleStick from "./CandleStick";

class CandleStickBox extends Component{
	constructor(props){
		super(props);
	}

	render(){
		const cssRow = this.props.hasOwnProperty("className") ? ` ${this.props.className}` : "";
		return (<div className={`candle-stick-box${cssRow}`}>
			<NewsItemTabs side={this.props.side}/>
			<CandleStick side={this.props.side}/>
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(CandleStickBox);