import { Component } from "react";
import { connect } from "react-redux";

import NavigationNews from "./NavigationNews";

import "./Widget.less";

class Widget extends Component{
	constructor(props){
		super(props);
	}

	render(){
		return (
		<div id="widget_box" className="widget">
			<NavigationNews />
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(Widget);