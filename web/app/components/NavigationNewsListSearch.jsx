import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";
import $ from "jquery";
import dxList from "devextreme/ui/list";

import { selectNews } from "../actions/ActionsWidget";

import SearchNewsBox from "./SearchNewsBox";

import NewsListSource from "../sources/NewsListSource";

import DataStore from "devextreme/data/data_source";

class NavigationNewsListSearch extends Component{
	constructor(props){
		super(props);
		this.list = null;
		this.dataSource =  new DataStore({
			store: NewsListSource(() => ({})),
			paginate: true,
			pageSize: 10
		});
		this.search = this.props.newsList.search;
	}
	shouldComponentUpdate(nextProps, nextState){
		if(nextProps.newsList.unselectAll){
			this.list.dxList("instance").unselectAll();
			console.log("search unselected");
		}
		if(this.search !== nextProps.newsList.search){
			this.search = nextProps.newsList.search;
			this.dataSource.searchValue(nextProps.newsList.search);
			this.dataSource.load();
		}
		return false;
	}
	componentDidMount(){
		this.list = $(ReactDOM.findDOMNode(this.refs.listSearch));
		this.list.dxList({
			dataSource: this.dataSource,
			height: 441,
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
			//noDataText: "Новостей нет",
			noDataText: "",
			pageLoadMode: "scrollBottom",
			pageLoadingText: "Загрузка...",
			onSelectionChanged: this.props.selectNews
		}).dxList("instance");
	}
	render(){
		return (<div className="list-news">
			<SearchNewsBox />
			<div ref="listSearch" />
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

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNewsListSearch);