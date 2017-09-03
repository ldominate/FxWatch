import Promise from "promise-polyfill";
if (!window.Promise) window.Promise = Promise;

import "whatwg-fetch";

import CustomStore from "devextreme/data/custom_store";

export default function (getParams){
	"use strict";
	return new CustomStore({
		load: loadOption => {
			"use strict";
			//console.log(loadOption);

			const params = getParams();

			const url = `/news/widget/news/data/${params.nid}/${params.fid}/${params.pid}`;

			return fetch(url)
				.then(function(response) {
					return response.json();
				}).then(function(json) {
					//console.log(groupNews);
					return json.map(nd => {
						nd.datetime = new Date(nd.datetime.replace(" ", "T"));
						return nd;
					});
				}).catch(function(ex) {
					console.log('parsing failed', ex);
				});
		},
		byKey: key => {
			"use strict";
			const d = new $.Deferred();

			console.log(key);
			return d.promise();
		},
		loadMode: "raw"
	});
}