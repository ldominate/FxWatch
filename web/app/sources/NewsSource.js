import CustomStore from "devextreme/data/custom_store";
import groupArray from "group-array";
import RestClient from "another-rest-client";

const api = new RestClient('http://fxwatch/news/widget');

api.res("news");

const pagination = {
	currentPage: 0,
	pageCount: 0,
	perPage: 20,
	totalCount: 0
};

function xPagination(){
	"use strict";

}

api.on('response', function(xhr) {
	pagination.currentPage = xhr.getResponseHeader("X-Pagination-Current-Page");
	pagination.pageCount = xhr.getResponseHeader("X-Pagination-Page-Count");
	pagination.perPage = xhr.getResponseHeader("X-Pagination-Per-Page");
	pagination.totalCount = xhr.getResponseHeader("X-Pagination-Total-Count");
	//console.log(pagination);
});

export default new CustomStore({
	load: loadOption => {
		"use strict";
		//console.log(loadOption);

		const param = {
			sort: "-published",
			limit: loadOption.take,
			page: Math.floor(loadOption.skip / pagination.perPage) + 1
		}

		return api.news.get(param)
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
				//console.log(groupNews);
				//return newsMap;
				return groupNews;
			});
	},
	totalCount: options => {
		"use strict";
		console.log(options);
		return api.news.get()
			.then((news) => {
				return news.length;
			});
	}
});
