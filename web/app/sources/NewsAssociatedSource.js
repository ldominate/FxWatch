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
			console.log(loadOption);
			const d = new $.Deferred();

			const params = getParams();
			if(params.nid <= 0) return;
			// const t = loadOption.take || 6;
			// const s = loadOption.skip || 0;
			const t = loadOption.take;
			const s = loadOption.skip;
			const url = t === undefined || s === undefined
				? wrapHost(`/news/widget/associated/${params.nid}`)
				: wrapHost(`/news/widget/associated/${params.nid}/${t}/${s}`);
			let totalCount = 0;

			fetch(url)
			.then(function(response) {
				totalCount = response.headers.get("X-Pagination-Total-Count");
				return response.json();
			}).then(function(json) {
				//console.log(groupNews);
				const result = json.map(nd => {
					nd.published = new Date(nd.published.replace(" ", "T"));
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
			//console.log(option);
			return 0;
		}
		// loadMode: "raw",
		// cacheRawData: false
	});
}
