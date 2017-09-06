/**
 * Created by johny on 03.09.2017.
 */
import { fromJS } from "immutable";

import {
	REQUEST_NEWS_WEEK,
	RECEIVE_NEWS_WEEK,
	SELECT_NEWS_ITEM,
	SELECT_PERIOD,
	SELECT_FINTOOL
} from "./ActionsWidget";

export const NEWS_SOURCE_WEEK = "NEWS_SOURCE_WEEK";

export function initSate(){
	"use strict";
	return {
		newsList: {
			sourceNews: NEWS_SOURCE_WEEK,
			grouped: true
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
		default:
			return state;
	}
}