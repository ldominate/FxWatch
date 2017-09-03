import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxTabs from "devextreme/ui/tabs";

class NavigationNewsTabs extends Component{
	constructor(props){
		super(props);
		this.tabs = null;
	}
	componentDidMount(){
		this.tabs = $(ReactDOM.findDOMNode(this));
		this.tabs.dxTabs({
			dataSource: ["Неделя", "Регион", "Поиск"],
			selectedIndex: 0,
			width: 200,
			onItemClick: function(e) {
				console.log(e);
				//selectBox.option("value", e.itemData.id);
			}
		});
	}
	render(){
		return (<div ref="tabs" className="tabs-container" />);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNewsTabs);