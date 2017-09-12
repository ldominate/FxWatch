import Promise from "promise-polyfill";
if (!window.Promise) window.Promise = Promise;

import "whatwg-fetch";

import CustomStore from "devextreme/data/custom_store";
import {wrapHost} from "./UrlHostPath";

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
		this.store = new CustomStore({
			load: loadOption => {
				"use strict";
				//console.log("pload");
				//console.log(loadOption);

				const url = wrapHost("/catalog/countries");
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

				//console.log(key);
				if(key){
					const country = this.data[this.getIndexById(key)];
					d.resolve({code: country.code, text: country.name});
				}else{
					d.resolve({code:"", text: ""});
				}
				return d.promise();
			},
			loadMode: "raw",
			cacheRawData:true
		});

		return instance;
	}
	receiveFetch(json){
		//console.log(json);
		this.fetch = null;
		this.data = json;
		return json.map(p => ({text: p.name, code: p.code}));
	}
	getStore(){
		return this.store;
	}
	getIndexById(code){
		if(this.data) {
			for (let i = 0; i < this.data.length; i++) {
				if (this.data[i].code === code) {
					return i;
				}
			}
		}
		return 0;
	}
}

export default new CustomStoreWrapper()
