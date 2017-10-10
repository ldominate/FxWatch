import Promise from "promise-polyfill";
if (!window.Promise) window.Promise = Promise;

import "whatwg-fetch";

import $ from "jquery";

import CustomStore from "devextreme/data/custom_store";
import {wrapHost} from "./UrlHostPath";

export default function (getParams){
	"use strict";
	return new CustomStore({
		load: loadOption => {
			"use strict";
			//console.log(loadOption);
			const d = new $.Deferred();

			const params = getParams();
			//console.log(params);
			params.t = loadOption.take || 10;
			params.s = loadOption.skip || 0;
			if(typeof loadOption.searchValue === "string" && loadOption.searchValue.length > 0){
				params.sch = loadOption.searchValue;
			}
			const esc = encodeURIComponent;
			const query = Object.keys(params)
				.map(k => {
					if(params[k] === "" || params[k] === null || params[k] === undefined) return "";
					return `${esc(k)}=${esc(params[k])}`;
				})
				.join("&");
			//console.log(query);

			const url = wrapHost(`/news/widget/list?${query}`);
			let totalCount = 0;

			fetch(url)
				.then(function(response) {
					totalCount = response.headers.get("X-Pagination-Total-Count");
					return response.json();
				}).then(function(json) {
				//console.log(groupNews);
				const result = json.map(nd => {
					if(nd.published !== null) {
						nd.published = new Date(nd.published.replace(" ", "T"));
					}
					return nd;
				});
				//console.log(totalCount);
				d.resolve(result, { totalCount: totalCount });
			}).catch(function(ex) {
				console.log('parsing failed', ex);
				d.reject('parsing failed');
			});

			return d.promise();
		},
		byKey: key => {
			"use strict";
			const d = new $.Deferred();

			console.log(key);
			return d.promise();
		},
		totalCount: option => {
			console.log(option);
		},
		// loadMode: "raw",
		// cacheRawData: false
	});
}