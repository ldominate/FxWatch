/**
 * Created by johny on 03.09.2017.
 */
import { fromJS } from "immutable";

import {
	REQUEST_NEWS_WEEK,
	RECEIVE_NEWS_WEEK
} from "./ActionsWidget";

export const NEWS_SOURCE_WEEK = "NEWS_SOURCE_WEEK";

export function initSate(){
	"use strict";
	return {
		newsList: {
			sourceNews: NEWS_SOURCE_WEEK,
			grouped: true
		}
	}
}

export default (state, action) => {
	"use strict";
	switch (action.type){

		default:
			return state;
	}
}
