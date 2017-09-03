import { Component } from "react";
import { connect } from "react-redux";

import $ from "jquery";
import dxTabs from "devextreme/ui/tabs";

import CatalogPeriodsSource from "../sources/CatalogPeriodsSource";

class PeriodNewsDataTabs extends Component{
	constructor(props){
		super(props);
		this.tabs = null;
	}
	componentDidMount(){
		this.tabs = $(ReactDOM.findDOMNode(this));
		this.tabs.dxTabs({
			dataSource: CatalogPeriodsSource.getStore(),
			selectedIndex: 0,
			width: 200,
			onItemClick: function(e) {
				console.log(e);
				//selectBox.option("value", e.itemData.id);
			}
		});
	}
	render(){
		return (<div></div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(PeriodNewsDataTabs);