import Promise from "promise-polyfill";
if (!window.Promise) window.Promise = Promise;

import "whatwg-fetch";

import CustomStore from "devextreme/data/custom_store";

import { wrapHost } from "./UrlHostPath";

let instance = null;

class CustomStoreWrapper {
	constructor(){
		if(!instance){
			instance = this;
			//console.log("inst");
		}
		//console.log("const");
		this.fetch = null;
		this.data = null;
		this.loadedFunc = (result) => { console.log(result)};
		this.store = new CustomStore({
			load: loadOption => {
				"use strict";
				//console.log("pload");
				//console.log(loadOption);

				const url = wrapHost("/catalog/periods");
				if(!this.fetch) {
					this.fetch = fetch(url)
						.then(function (response) {
							return response.json();
						}).then(this.receiveFetch.bind(this)).catch(function (ex) {
							console.log('parsing failed', ex);
						});
				}
				return this.fetch;
			},
			byKey: key => {
				"use strict";
				const d = new $.Deferred();

				console.log(key);
				return d.promise();
			},
			onLoaded: this.loadedFuncIn.bind(this),
			loadMode: "raw",
			cacheRawData:true
		});

		return instance;
	}
	receiveFetch(json){
		//console.log(json);
		this.fetch = null;
		this.data = json;
		return json.map(p => ({id: p.id, text: p.name}));
	}
	getStore(){
		return this.store;
	}
	loadedFuncIn(result){
		if(typeof this.loadedFunc === "function"){
			this.loadedFunc(result);
		}
	}
	setLoadedFunc(loadedFunc){
		this.loadedFunc = loadedFunc;
	}
	getIndexById(id){
		if(this.data) {
			for (let i = 0; i < this.data.length; i++) {
				if (this.data[i].id === id) {
					return i;
				}
			}
		}
		return 0;
	}
}

export default new CustomStoreWrapper()