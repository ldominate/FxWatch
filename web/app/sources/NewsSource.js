import CustomStore from "devextreme/data/custom_store";
import groupArray from "group-array";
import RestClient from "another-rest-client";

const api = new RestClient('http://fxwatch/news/widget');

api.res("news");

export default new CustomStore({
	load: loadOption => {
		"use strict";
		console.log(loadOption);
		return api.news.get({sort: "-published"})
			.then((news) => {
				const newsMap = news.map(n => {
					n.published = new Date(n.published.replace(" ", "T"));
					//console.log(n);
					n.publishedDay = n.published.toLocaleDateString();
					return n;
				});
				const groupNewsKey = groupArray(newsMap, "publishedDay");
				let groupNews = [];
				for(let prop in groupNewsKey){
					groupNews.push({key: groupNewsKey[prop][0].published, items: groupNewsKey[prop]})
				}
				console.log(groupNews);
				return groupNews;
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
