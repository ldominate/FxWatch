import CatalogFintoolGroupSource from "../sources/CatalogFintoolGroupSource";
import { getSidesFintool } from "./CurrencyMapFintool";

export const REQUEST_NEWS_WEEK = "REQUEST_NEWS_WEEK";
export function requestNewsWeek(){
	"use strict";

}

export const RECEIVE_NEWS_WEEK = "RECEIVE_NEWS_WEEK";
export function receiveNewsWeek(){
	"use strict";

}

export const SELECT_NEWS_ITEM = "SELECT_NEWS_ITEM";
export function selectNews(news){
	"use strict";
	//const fintoolG = CatalogFintoolGroupSource.getStore();
	//console.log(CatalogFintoolGroupSource.data);
	// const loadFinG = fintoolG.load({});
	const sideName = getSidesFintool(news.currency_code);
	console.log(sideName);
	const fintoolSide = {
		sides: {
			left: CatalogFintoolGroupSource.getFintoolIdByName(sideName.left),
			right: CatalogFintoolGroupSource.getFintoolIdByName(sideName.right)
		},
	};
	return {...{type: SELECT_NEWS_ITEM}, ...news, ...fintoolSide};
}