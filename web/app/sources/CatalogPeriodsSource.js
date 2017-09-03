import Promise from "promise-polyfill";
if (!window.Promise) window.Promise = Promise;

import "whatwg-fetch";

import CustomStore from "devextreme/data/custom_store";

let instance = null;

class CustomStoreWrapper {
	constructor(){
		if(!instance){
			instance = this;
			console.log("inst");
		}
		console.log("const");
		this.store = new CustomStore({
			load: loadOption => {
				"use strict";
				console.log("pload");
				console.log(loadOption);

				const url = `/catalog/periods`;

				return fetch(url)
					.then(function(response) {
						return response.json();
					}).then(function(json) {
						//console.log(json);
						return json.map(p => ({id: p.id, text: p.name}));
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
			loadMode: "raw",
			cacheRawData:true
		});

		return instance;
	}
	getStore(){
		return this.store;
	}
}

export default new CustomStoreWrapper()