/**
 * Created by johny on 26.08.2017.
 */

import $ from "jquery";
import RestClient from "another-rest-client";

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

	api.news.get({currency_code: "USD"}).then((news) => {
		console.log(news);
	});
	// api.news.get().then((news) => {
	// 	console.log(news);
	// });
	// api.news(3).patch({release: "Dada"}).then((news) => {
	// 	console.log(news);
	// });
});