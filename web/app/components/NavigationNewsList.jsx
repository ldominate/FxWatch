import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";
import $ from "jquery";
import dxList from "devextreme/ui/list";

import NewsWeekSource from "../sources/NewsWeekSource";

class NavigationNewsList extends Component{
	constructor(props){
		super(props);
		this.list = null;
	}
	componentDidMount() {
		this.list = $(ReactDOM.findDOMNode(this));
		this.list.dxList({
			dataSource: NewsWeekSource,
			grouped: true,
			height: 356,
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
			}
		}).dxList("instance");
	}
	render(){
		return (<div className="list-news"></div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNewsList);