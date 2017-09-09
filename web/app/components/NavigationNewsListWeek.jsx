import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";
import $ from "jquery";
import dxList from "devextreme/ui/list";

import { selectNews } from "../actions/ActionsWidget";

import NewsWeekSource from "../sources/NewsWeekSource";

class NavigationNewsListWeek extends Component{
	constructor(props){
		super(props);
		this.list = null;
	}
	shouldComponentUpdate(nextProps, nextState) {
		if(nextProps.newsList.unselectAll){
			this.list.dxList("instance").unselectAll();
		}
		return false;
	}
	componentDidMount() {
		this.list = $(ReactDOM.findDOMNode(this));
		this.list.dxList({
			dataSource: NewsWeekSource,
			grouped: true,
			height: 356,
			selectionMode: "single",
			showSelectionControls: false,
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
			onSelectionChanged: this.props.selectNews
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
		return;
	}
});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNewsListWeek);