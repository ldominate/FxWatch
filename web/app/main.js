/**
 * Created by johny on 26.08.2017.
 */

import $ from "jquery";
import RestClient from "another-rest-client";
import dxList from "devextreme/ui/list";
import dxTabs from "devextreme/ui/tabs";
import  NewsSource from "./sources/NewsSource";

import "dxCommonCss";
import "dxLightCss";

import "flag-icon-css/css/flag-icon";

import "./widget.less";

const api = new RestClient('http://fxwatch/news/widget');

api.res("news");

api.on('response', function(xhr) {
	//xhr.setRequestHeader('Authorization', 'Bearer xxxTOKENxxx');
	//console.log(xhr);
	const header = xhr.getResponseHeader("X-Pagination-Total-Count");
	console.log(header);
});

$("#gmi").on("click", (btn) => {
	"use strict";

	api.news.get({currency_code: "USD", sort: "-published"}).then((news) => {
		console.log(news);
	});
	// api.news.get().then((news) => {
	// 	console.log(news);
	// });
	// api.news(3).patch({release: "Dada"}).then((news) => {
	// 	console.log(news);
	// });
});

$(".navigation-box > .tabs-container").dxTabs({
	dataSource: ["Неделя", "Регион", "Поиск"],
	selectedIndex: 0,
	width: 200,
	onItemClick: function(e) {
		console.log(e);
		//selectBox.option("value", e.itemData.id);
	}
})

$("#news_list").dxList({
	dataSource: NewsSource,
	grouped: true,
	height: 356,
	groupTemplate: function(data) {
		return $(`<b>${data.key.toLocaleDateString("ru-RU", {weekday: "short", month: "short", day: "2-digit", formatMatcher: "basic"})}</b>`);

	},
	itemTemplate: function(data, index) {
		const result = $("<div>").addClass("item-news");

		$("<div>").addClass("time-news").text(data.published.toLocaleTimeString("ru-RU", {hour:"numeric", minute: "2-digit"})).appendTo(result);
		$("<div>").html(`<span class="flag-icon flag-icon-${data.country_code.toLowerCase()}"></span>${data.countryCode}`).appendTo(result);
		$("<div>").html(data.categorynews).appendTo(result);
		// 	.html(Globalize.formatCurrency(data.Price, "USD", { maximumFractionDigits: 0 })).appendTo(result);
		return result;
	}
});
