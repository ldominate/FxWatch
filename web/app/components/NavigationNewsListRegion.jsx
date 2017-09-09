import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";
import $ from "jquery";
import dxList from "devextreme/ui/list";

import { selectNews } from "../actions/ActionsWidget";

import SelectCountryBox from "./SelectCountryBox";

import NewsListSource from "../sources/NewsListSource";

import DataStore from "devextreme/data/data_source";

class NavigationNewsListRegion extends Component{
	constructor(props){
		super(props);
		this.list = null;
		this.country = this.props.newsList.country;
	}
	shouldComponentUpdate(nextProps, nextState){
		if(nextProps.newsList.unselectAll){
			this.list.dxList("instance").unselectAll();
		}
		console.log(nextProps);
		this.country = nextProps.newsList.country;
		this.list.dxList("instance").reload();
		return false;
	}
	componentDidMount(){
		this.list = $(ReactDOM.findDOMNode(this.refs.listRegion));
		this.list.dxList({
			dataSource: new DataStore({
				store: NewsListSource(this.getParams.bind(this)),
				paginate: true,
				pageSize: 10
			}),
			height: 332,
			selectionMode: "single",
			showSelectionControls: false,
			itemTemplate: function(data, index) {
				const result = $("<div>").addClass("item-news");

				$("<div>").addClass("time-news").text(data.published.toLocaleTimeString("ru-RU", {
					month: "2-digit",
					day: "2-digit",
					year: "numeric",
					hour:"numeric",
					minute: "2-digit"})
				).appendTo(result);
				$("<div>").html(`<span class="flag-icon flag-icon-${data.country_code.toLowerCase()}"></span>${data.countryCode}`)
					.appendTo(result);
				$("<div>").html(data.categorynews)
					.appendTo(result);
				return result;
			},
			nextButtonText: "Загрузить ещё...",
			noDataText: "Новостей нет",
			pageLoadMode: "scrollBottom",
			pageLoadingText: "Загрузка...",
			onSelectionChanged: this.props.selectNews
		}).dxList("instance");
	}
	getParams(){
		return {c: this.country};
	}
	render(){
		return (<div className="list-news">
			<SelectCountryBox/>
			<div ref="listRegion"/>
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
	}
});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNewsListRegion);