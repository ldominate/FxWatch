import Promise from "promise-polyfill";
if (!window.Promise) window.Promise = Promise;

import "whatwg-fetch";

import $ from "jquery";
import CustomStore from "devextreme/data/custom_store";

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
		this.defKey = null;
		this.store = new CustomStore({
			load: loadOption => {
				"use strict";
				//console.log("pload");
				//console.log(loadOption);

				const url = "/catalog/fintoolgroups";
				if(!this.fetch) {
					this.fetch = fetch(url)
						.then(function (response) {
							return response.json();
						}).then(this.receiveFetch.bind(this))
						.catch(function (ex) {
							console.log('parsing failed', ex);
						});
				}
				return this.fetch;
			},
			byKey: key => {
				"use strict";
				const d = new $.Deferred();
				if(/[g]\d+/.test(key)){

				}else if(this.data) {
					this.data.forEach(item => {
						item.fintools.forEach(tool => {
							if(tool.id === key){
								d.resolve(tool);
								return d.promise();
							}
						});
					});
				}else{
					this.defKey = {d, key};
				}
				console.log(key);
				return d.promise();
			},
			loadMode: "raw",
			cacheRawData:true
		});

		return instance;
	}
	keyResolve(){
		console.log(this.defKey);
		if(this.defKey){
			this.data.forEach(item => {
				item.fintools.forEach(tool => {
					if(tool.id === this.defKey.key){
						console.log(this.defKey.key);
						this.defKey.d.resolve(tool);
					}
				});
			});
		}
	}
	receiveFetch(json){
		//console.log(json);
		this.fetch = null;
		this.data = json.map((fg, index) => ({id: `g${fg.id}`, name: fg.name, expanded: index === 0, fintools: fg.fintools}));
		this.keyResolve();
		return this.data;
	}
	getStore(){
		return this.store;
	}
	getFintoolIdByName(name){
		let result = 0;
		this.data.forEach(item => {
			item.fintools.forEach(tool => {
				// console.log(name);
				// console.log(tool);
				// console.log(tool.name === name);
				if(tool.name === name){
					result = tool.id;
				}
			});
		});
		return result;
	}
}

export default new CustomStoreWrapper()