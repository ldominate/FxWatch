import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";
import $ from "jquery";
import dxList from "devextreme/ui/list";

import SelectCountryBox from "./SelectCountryBox";

class NavigationNewsListRegion extends Component{
	constructor(props){
		super(props);
		this.list = null;
	}
	shouldComponentUpdate(nextProps, nextState){
		if(nextProps.newsList.unselectAll){
			this.list.dxList("instance").unselectAll();
		}
		return false;
	}
	componentDidMount(){

	}
	render(){
		return (<div className="list-news">
			<SelectCountryBox/>
			<div />
		</div>);
	}
}

const mapStateToProps = (state) => ({
	newsList: state.get("newsList").toJSON()
});

const mapDispatchToProps = (dispatch) => ({
	selectNews: (params) => {
		if(Array.isArray(params.addedItems) && params.addedItems.length){
			return dispatch(selectNews(params.addedItems[0]))
		}
		return;
	}
});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNewsListRegion);