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
	onItemClick: function(e) {
		console.log(e);
		//selectBox.option("value", e.itemData.id);
	}
})

$("#news_list").dxList({
	dataSource: NewsSource,
	itemTemplate: function(data, index) {
		var result = $("<div>").addClass("news");

		//$("<img>").attr("src", data.ImageSrc).appendTo(result);
		$("<span>").text(data.currency_code).appendTo(result);
		$("<span>").text(data.published.toLocaleTimeString()).appendTo(result);
		// $("<div>").addClass("price")
		// 	.html(Globalize.formatCurrency(data.Price, "USD", { maximumFractionDigits: 0 })).appendTo(result);

		return result;

	}
});
