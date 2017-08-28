import CustomStore from "devextreme/data/custom_store";
import RestClient from "another-rest-client";

const api = new RestClient('http://fxwatch/news/widget');

api.res("news");

export default new CustomStore({
	load: loadOption => {
		"use strict";
		console.log(loadOption);
		return api.news.get({sort: "-published"})
			.then((news) => {
				return news.map(n => {
					n.published = new Date(n.published.replace(" ", "T"));
					console.log(n);
					return n;
				});
			});
	},
	totalCount: options => {
		"use strict";
		return api.news.get()
			.then((news) => {
				return news.length;
			});
	}
});
