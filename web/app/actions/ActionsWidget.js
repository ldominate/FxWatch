import CatalogFintoolGroupSource from "../sources/CatalogFintoolGroupSource";
import { getSidesFintool } from "./CurrencyMapFintool";
import {wrapHost} from "../sources/UrlHostPath";

export const REQUEST_NEWS_WEEK = "REQUEST_NEWS_WEEK";
export function requestNewsWeek(){
	"use strict";

}

export const RECEIVE_NEWS_WEEK = "RECEIVE_NEWS_WEEK";
export function receiveNewsWeek(){
	"use strict";

}

function makeFintoolSide(news){
	"use strict";
	//console.log(news);
	const sideName = getSidesFintool(news.currency_code);
	//console.log(sideName);
	return {
		sides: {
			left: CatalogFintoolGroupSource.getFintoolIdByName(sideName.left),
			right: CatalogFintoolGroupSource.getFintoolIdByName(sideName.right)
		},
	};
}

export const SELECT_NEWS_ITEM = "SELECT_NEWS_ITEM";
export function selectNews(news){
	"use strict";

	return {...{type: SELECT_NEWS_ITEM}, ...news, ...makeFintoolSide(news)};
}

export const SELECT_NEWS_ASSOCIATED = "SELECT_NEWS_ASSOCIATED";
export function selectAssociatedNews(news){
	"use strict";

	return {...{type: SELECT_NEWS_ASSOCIATED}, ...news, ...makeFintoolSide(news)};
}

export const SELECT_PERIOD = "SELECT_PERIOD";
export function selectPeriod(periodSide){
	"use strict";
	//console.log(periodSide);
	return {...{type: SELECT_PERIOD}, ...periodSide };
}

export const SELECT_FINTOOL = "SELECT_FINTOOL";
export function selectFintool(fintoolSide){
	"use strict";
	return {type: SELECT_FINTOOL, ...fintoolSide};
}

export const NEWS_SOURCE_WEEK = "NEWS_SOURCE_WEEK";
export const NEWS_SOURCE_REGION = "NEW_SOURCE_REGION";
export const NEWS_SOURCE_SEARCH = "NEWS_SOURCE_SEARCH";

export const SELECT_NEWS_SOURCE = "SELECT_NEWS_SOURCE";
export function selectNewsSource(item){
	"use strict";
	return {type: SELECT_NEWS_SOURCE, ...item};
}

export const SELECT_COUNTRY_NEWS = "SELECT_COUNTRY_NEWS";
export function selectCountry(code){
	"use strict";
	return {type: SELECT_COUNTRY_NEWS, code:code};
}

export const SEARCH_NEWS = "SEARCH_NEWS";
export function searchNews(search){
	return {type: SEARCH_NEWS, search: search};
}

export const LOADED_FINTOOL = "LOADED_FINTOOL";
export function loadedFintool(){
	return {type: LOADED_FINTOOL};
}

export const LOADED_PERIOD = "LOADED_PERIOD";
export function loadedPeriod(){
	return {type: LOADED_PERIOD};
}

export const SELECTED_FIRST_NEWS = "SELECTED_FIRST_NEWS";
export function selectedFirst(){
	return {type: SELECTED_FIRST_NEWS};
}

export const REQUEST_NEWS_CATEGORY = "REQUEST_NEWS_CATEGORY";
export function requestNewsCategory(skip){
	return {type: REQUEST_NEWS_CATEGORY, skip};
}

export const RECEIVE_NEWS_CATEGORY = "RECEIVE_NEWS_CATEGORY";
export function receiveNewsCategory(news){
	return {type: RECEIVE_NEWS_CATEGORY, ...news, ...makeFintoolSide(news)};
}

export const RECEIVE_EMPTY_NEWS_CATEGORY = "RECEIVE_EMPTY_NEWS_CATEGORY";
export function receiveEmptyNewsCategory(){
	return {type: RECEIVE_EMPTY_NEWS_CATEGORY};
}

export function reachNewsCategory(){

	return function (dispatch, getState){

		const state = getState();

		const nid = state.getIn(["graphs", 0, "news", "id"]);
		let skip = state.get("skip");
		//console.log(nid);
		skip++;

		const url = wrapHost(`/news/widget/category/${nid}/1/${skip}`);
		let totalCount = 0;

		dispatch(requestNewsCategory(skip));

		return fetch(url)
			.then(response => {
				totalCount = response.headers.get("X-Pagination-Total-Count");
				return response.json();
			})
			.then(json => {
				console.log(json);
				if(!Array.isArray(json)) throw "Receive not array";
				if(json.length <= 0) {
					dispatch(receiveEmptyNewsCategory());
				}else{
					dispatch(receiveNewsCategory(json.map(nd => {
						nd.published = new Date(nd.published.replace(" ", "T"));
						return nd;
					})[0]));
				}
			})
			.catch(ex => {
				console.log('parsing failed', ex);
			});
	}
}