import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";
import $ from "jquery";
import dxList from "devextreme/ui/list";

import { selectNews, selectedFirst } from "../actions/ActionsWidget";

import NewsWeekSource from "../sources/NewsWeekSource";

class NavigationNewsListWeek extends Component{
	constructor(props){
		super(props);
		this.list = null;
		this.dataSource = NewsWeekSource(this.loadingData.bind(this));
		//this.dataSource.load();
		this.isLoaded = false;
		//this.dataSource.on("onLoaded", this.loadingData);
	}
	shouldComponentUpdate(nextProps, nextState) {
		if(nextProps.newsList.unselectAll){
			this.list.dxList("instance").unselectAll();
		}
		if(nextProps.newsList.selectFirst){
			if(this.isLoaded) this.list.dxList("instance").selectItem({ group: 0, item: 0});
			this.props.selectedFirst();
		}
		return false;
	}
	loadingData(){
		//console.log("this");
		this.isLoaded = true;
		//this.list.dxList("instance").selectItem({ group: 0, item: 0});
	}
	componentDidMount() {
		this.list = $(ReactDOM.findDOMNode(this));
		this.list.dxList({
			dataSource: this.dataSource,
			grouped: true,
			height: 479,
			selectionMode: "single",
			showSelectionControls: false,
			noDataText: "На неделе новостей нет",
			groupTemplate: function(data) {
				return $(`<b>${data.key.toLocaleDateString("ru-RU", {
					weekday: "short",
					month: "short",
					day: "2-digit",
					formatMatcher: "basic"})}</b>`);

			},
			itemTemplate: function(data, index) {
				const result = $("<div>").addClass("item-news");

				$("<div>").addClass("time-news").text(data.published.toLocaleTimeString("ru-RU", {
					hour:"numeric",
					minute: "2-digit"})
				).appendTo(result);
				$("<div>").html(`<span class="flag-icon flag-icon-${data.country_code.toLowerCase()}"></span>${data.countryCode}`)
					.appendTo(result);
				$("<div>").html(data.categorynews)
					.appendTo(result);
				return result;
			},
			onSelectionChanged: this.props.selectNews,
			onContentReady: e => {
				//console.log("ready");
				//if(this.isLoaded) e.component.selectItem({ group: 0, item: 0});
			}
		}).dxList("instance");
	}
	render(){
		return (<div className="list-news" />);
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
	},
	selectedFirst: () => dispatch(selectedFirst())
});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNewsListWeek);