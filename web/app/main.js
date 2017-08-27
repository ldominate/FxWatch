/**
 * Created by johny on 26.08.2017.
 */

import $ from "jquery";
import RestClient from "another-rest-client";

const api = new RestClient('http://fxwatch/news/widget');

api.res("news");

$("#gmi").on("click", (btn) => {
	"use strict";

	// api.news(3).get().then((news) => {
	// 	console.log(news);
	// });
	api.news(3).patch({release: "Dada"}).then((news) => {
		console.log(news);
	});
});