import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxTabs from "devextreme/ui/tabs";

import {NEWS_SOURCE_WEEK, NEWS_SOURCE_REGION, NEWS_SOURCE_SEARCH,
	selectNewsSource } from "../actions/ActionsWidget";

class NavigationNewsTabs extends Component{
	constructor(props){
		super(props);
		this.tabs = null;
	}
	componentDidMount(){
		this.tabs = $(ReactDOM.findDOMNode(this));
		this.tabs.dxTabs({
			dataSource: [
				{id: NEWS_SOURCE_WEEK, text: "Неделя"},
				{id: NEWS_SOURCE_REGION, text:"Регион"},
				{id: NEWS_SOURCE_SEARCH, text:"Поиск"}
			],
			selectedIndex: 0,
			width: 200,
			onItemClick: this.props.selectSource
		});
	}
	render(){
		return (<div ref="tabs" className="tabs-container" />);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({
	selectSource: (e) => dispatch(selectNewsSource(e.itemData))
});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNewsTabs);