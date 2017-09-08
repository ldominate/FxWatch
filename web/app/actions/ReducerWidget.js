/**
 * Created by johny on 03.09.2017.
 */
import { fromJS } from "immutable";

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
	NEWS_SOURCE_SEARCH
} from "./ActionsWidget";


export function initSate(){
	"use strict";
	return {
		newsList: {
			sourceNews: NEWS_SOURCE_WEEK,
			grouped: true,
			unselectAll: false,
			country: ""
		},
		news: {
			id: 0,
			currency: "",
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
				m.setIn(["news", "id"], action.id);
				m.setIn(["news", "currency"], action.currency_code);
				m.setIn(["leftCandle", "fintool"], action.sides.left);
				m.setIn(["rightCandle", "fintool"], action.sides.right);
			});
		}
		case SELECT_NEWS_ASSOCIATED:{
			return state.withMutations(m => {
				if(!m.getIn(["newsList", "unselectAll"])){
					m.setIn(["newsList", "unselectAll"], true);
				}
				m.setIn(["news", "id"], action.id);
				m.setIn(["news", "currency"], action.currency_code);
				m.setIn(["leftCandle", "fintool"], action.sides.left);
				m.setIn(["rightCandle", "fintool"], action.sides.right);
			});
		}
		case SELECT_PERIOD:{
			return state.withMutations(m => {
				m.setIn([action.side, "period"], action.id);
			});
		}
		case SELECT_FINTOOL:{
			return state.withMutations(m => {
				m.setIn([action.side, "fintool"], action.id);
			});
		}
		case SELECT_NEWS_SOURCE:{
			return state.setIn(["newsList", "sourceNews"], action.id);
		}
		case SELECT_COUNTRY_NEWS: {
			return state.setIn(["newsList", "country"], action.code);
		}
		default:
			return state;
	}
}
