import Promise from "promise-polyfill";
if (!window.Promise) window.Promise = Promise;

import "whatwg-fetch";

import $ from "jquery";
import CustomStore from "devextreme/data/custom_store";
import groupArray from "group-array";
import {wrapHost} from "./UrlHostPath";

export default function (onLoaded) {
	return new CustomStore({
		load: loadOption => {
			"use strict";
			//console.log(loadOption);

			const url = wrapHost(`/news/widget/newsweek/1000/0`);

			return fetch(url)
				.then(function (response) {
					return response.json();
				}).then(function (json) {
					const newsMap = json.map(nd => {
						nd.published = new Date(nd.published.replace(" ", "T"));
						nd.publishedDay = nd.published.toLocaleDateString();
						return nd;
					});
					const groupNewsKey = groupArray(newsMap, "publishedDay");
					let groupNews = [];
					for (let prop in groupNewsKey) {
						groupNews.push({key: groupNewsKey[prop][0].published, items: groupNewsKey[prop]})
					}
					//console.log(groupNews);
					return groupNews;
				}).catch(function (ex) {
					console.log('parsing failed', ex);
				});
		},
		byKey: key => {
			"use strict";
			const d = new $.Deferred();

			console.log(key);
			return d.promise();
		},
		onLoaded: result => {
		 	//console.log(result);
		 	onLoaded();
		},
		loadMode: "raw"
	});
}