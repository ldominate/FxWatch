/**
 * Created by johny on 03.09.2017.
 */
import { fromJS, List } from "immutable";

import {
	REQUEST_NEWS_WEEK,
	RECEIVE_NEWS_WEEK,
	SELECT_NEWS_ITEM,
	SELECT_NEWS_ASSOCIATED,
	SELECT_PERIOD,
	SELECT_FINTOOL,
	SELECT_NEWS_SOURCE,
	SELECT_COUNTRY_NEWS,
	NEWS_SOURCE_WEEK,
	NEWS_SOURCE_REGION,
	NEWS_SOURCE_SEARCH,
	SEARCH_NEWS,
	LOADED_FINTOOL,
	LOADED_PERIOD,
	SELECTED_FIRST_NEWS,
	REQUEST_NEWS_CATEGORY,
	RECEIVE_NEWS_CATEGORY,
	RECEIVE_EMPTY_NEWS_CATEGORY
} from "./ActionsWidget";

export function initSate(){
	"use strict";
	return {
		newsList: {
			sourceNews: NEWS_SOURCE_WEEK,
			grouped: true,
			unselectAll: false,
			country: "",
			search: "",
			isLoadFintool: false,
			isLoadPeriod: false,
			selectFirst: false
		},
		news: {
			id: 0,
			currency: "",
			published: null,
			categorynews: ""
		},
		leftCandle: {
			period: 1,
			fintool: 0,
		},
		rightCandle: {
			period: 1,
			fintool: 0
		},
		skip: 0,
		endCategory: false,
		graphs: []
	}
}

export function createGraphBox(){
	return {
		news: {
			id: 0,
			currency: "",
			published: null,
			categorynews: ""
		},
		leftCandle: {
			period: 1,
			fintool: 0,
		},
		rightCandle: {
			period: 1,
			fintool: 0
		}
	}
}

export default (state, action) => {
	"use strict";
	console.log(action);
	switch (action.type){
		case SELECT_NEWS_ITEM:{
			return state.withMutations(m => {
				if(m.getIn(["newsList", "unselectAll"])) {
					m.setIn(["newsList", "unselectAll"], false);
				}
				// m.updateIn(["graphs", 0], g => {
				// 	g.setIn(["news", "id"], action.id);
				// 	g.setIn(["news", "published"], action.published);
				// 	g.setIn(["news", "categorynews"], action.categorynews);
				// 	g.setIn(["news", "currency"], action.currency_code);
				// 	g.setIn(["leftCandle", "fintool"], action.sides.left);
				// 	g.setIn(["rightCandle", "fintool"], action.sides.right);
				// });
				m.set("graphs", fromJS([{
					news: {
						id: action.id,
						currency: action.currency_code,
						published: action.published,
						categorynews: action.categorynews
					},
					leftCandle: {
						period: 1,
						fintool: action.sides.left,
					},
					rightCandle: {
						period: 1,
						fintool: action.sides.right
					}
				}]));
				m.set("skip", 0);
				m.set("endCategory", false);
				// m.setIn(["news", "id"], action.id);
				// m.setIn(["news", "published"], action.published);
				// m.setIn(["news", "categorynews"], action.categorynews);
				// m.setIn(["news", "currency"], action.currency_code);
				// m.setIn(["leftCandle", "fintool"], action.sides.left);
				// m.setIn(["rightCandle", "fintool"], action.sides.right);
			});
		}
		case SELECT_NEWS_ASSOCIATED:{
			return state.withMutations(m => {
				if(!m.getIn(["newsList", "unselectAll"])){
					m.setIn(["newsList", "unselectAll"], true);
				}
				m.setIn(["news", "id"], action.id);
				m.setIn(["news", "published"], action.published);
				m.setIn(["news", "categorynews"], action.categorynews);
				m.setIn(["news", "currency"], action.currency_code);
				m.setIn(["leftCandle", "fintool"], action.sides.left);
				m.setIn(["rightCandle", "fintool"], action.sides.right);
			});
		}
		case SELECT_PERIOD:{
			return state.withMutations(m => {
				m.setIn(["graphs", action.index, action.side, "period"], action.id);
			});
		}
		case SELECT_FINTOOL:{
			return state.withMutations(m => {
				m.setIn(["graphs", action.index, action.side, "fintool"], action.id);
			});
		}
		case SELECT_NEWS_SOURCE:{
			return state.setIn(["newsList", "sourceNews"], action.id);
		}
		case SELECT_COUNTRY_NEWS: {
			return state.setIn(["newsList", "country"], action.code);
		}
		case SEARCH_NEWS: {
			return state.setIn(["newsList", "search"], action.search);
		}
		case LOADED_FINTOOL: {
			if(state.getIn(["newsList", "isLoadFintool"])) return state;
			return state.update("newsList", nl => nl.withMutations(nlm => {
				nlm.set("isLoadFintool", true);
				if(nlm.get("isLoadPeriod")){
					nlm.set("selectFirst", true);
				}
			}));
		}
		case LOADED_PERIOD: {
			if(state.getIn(["newsList", "isLoadPeriod"])) return state;
			return state.update("newsList", nl => nl.withMutations(nlm => {
				nlm.set("isLoadPeriod", true);
				if(nlm.get("isLoadFintool")){
					nlm.set("selectFirst", true);
				}
			}))
		}
		case SELECTED_FIRST_NEWS: {
			return state.setIn(["newsList", "selectFirst"], false);
		}
		case REQUEST_NEWS_CATEGORY: {
			return state.set("skip", action.skip);
		}
		case RECEIVE_NEWS_CATEGORY: {
			return state.update("graphs", gl => {
				const item = fromJS({
					news: {
						id: action.id,
						currency: action.currency_code,
						published: action.published,
						categorynews: action.categorynews
					},
					leftCandle: {
						period: 1,
						fintool: action.sides.left,
					},
					rightCandle: {
						period: 1,
						fintool: action.sides.right
					}
				});
				//console.log(item);
				return gl.push(item);
			});
		}
		case RECEIVE_EMPTY_NEWS_CATEGORY: {
			return state.set("endCategory", true);
		}
		default:
			return state;
	}
}
