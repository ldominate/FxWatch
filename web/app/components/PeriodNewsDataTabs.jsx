import { Component } from "react";
import { connect } from "react-redux";

import $ from "jquery";
import dxTabs from "devextreme/ui/tabs";

import CatalogPeriodsSource from "../sources/CatalogPeriodsSource";

import { selectPeriod, loadedPeriod } from "../actions/ActionsWidget";

class PeriodNewsDataTabs extends Component{
	constructor(props){
		super(props);
		this.tabs = null;
	}
	shouldComponentUpdate(nextProps, nextState) {
		//console.log(nextProps.value);
		this.tabs.dxTabs("instance").beginUpdate();
		this.tabs.dxTabs("instance").option({
			"selectedIndex": CatalogPeriodsSource.getIndexById(nextProps.value)
		});
		this.tabs.dxTabs("instance").endUpdate();
		return false;
	}
	componentDidMount(){
		CatalogPeriodsSource.setLoadedFunc(this.props.loadedPeriod);
		this.tabs = $(ReactDOM.findDOMNode(this));
		this.tabs.dxTabs({
			dataSource: CatalogPeriodsSource.getStore(),
			selectedIndex: CatalogPeriodsSource.getIndexById(this.props.value),
			width: 200,
			onSelectionChanged: e => {
				//console.log(e);
				return this.props.selectPeriod({...e.addedItems[0], ...{side: this.props.side}});
			}
		});
	}
	render(){
		return (<div className="period_tabs" />);
	}
}

const mapStateToProps = (state, ownProps) => ({
	value: state.getIn([ownProps.side, "period"])
});

const mapDispatchToProps = (dispatch) => ({
	selectPeriod: (periodSide) => dispatch(selectPeriod(periodSide)),
	loadedPeriod: (result) => dispatch(loadedPeriod())
});

export default connect(mapStateToProps, mapDispatchToProps)(PeriodNewsDataTabs);