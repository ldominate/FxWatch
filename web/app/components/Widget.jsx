import { Component } from "react";
import { connect } from "react-redux";

import NavigationNews from "./NavigationNews";
import MainBox from "./MainBox";

import CatalogPeriodsSource from "../sources/CatalogPeriodsSource";
import CatalogFintoolGroupSource from "../sources/CatalogFintoolGroupSource";
import { loadedPeriod, loadedFintool } from "../actions/ActionsWidget";

import "./Widget.less";
import "flag-icon-css/css/flag-icon";

class Widget extends Component{
	constructor(props){
		super(props);
	}
	componentDidMount(){
		CatalogPeriodsSource.setLoadedFunc(this.props.loadedPeriod);
		CatalogFintoolGroupSource.setLoadedFunc(this.props.loadedFintool);
		CatalogPeriodsSource.getStore().load();
		CatalogFintoolGroupSource.getStore().load();
	}
	render(){
		return (
		<div id="widget_box" className="widget">
			<NavigationNews/>
			<MainBox/>
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({
	loadedPeriod: (result) => dispatch(loadedPeriod()),
	loadedFintool: (result) => dispatch(loadedFintool())
});

export default connect(mapStateToProps, mapDispatchToProps)(Widget);