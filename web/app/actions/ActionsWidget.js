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
	return {...{type: SELECT_FINTOOL}, ...fintoolSide};
}

export const NEWS_SOURCE_WEEK = "NEWS_SOURCE_WEEK";
export const NEWS_SOURCE_REGION = "NEW_SOURCE_REGION";
export const NEWS_SOURCE_SEARCH = "NEWS_SOURCE_SEARCH";

export const SELECT_NEWS_SOURCE = "SELECT_NEWS_SOURCE";
export function selectNewsSource(item){
	"use strict";

	return {...{type: SELECT_NEWS_SOURCE}, ...item};
}

export const SELECT_COUNTRY_NEWS = "SELECT_COUNTRY_NEWS";
export function selectCountry(code){
	"use strict";
	return {...{type: SELECT_COUNTRY_NEWS}, ...{code:code}};
}

export const SEARCH_NEWS = "SEARCH_NEWS";
export function searchNews(search){
	return {...{type: SEARCH_NEWS}, ...{search: search}};
}