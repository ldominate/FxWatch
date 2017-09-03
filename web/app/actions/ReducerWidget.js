/**
 * Created by johny on 03.09.2017.
 */
import { fromJS } from "immutable";

import {
	REQUEST_NEWS_WEEK,
	RECEIVE_NEWS_WEEK
} from "./ActionsWidget";

export function initSate(){
	"use strict";
	return {
		sourceNewsList: 0
	}
}

export default (state, action) => {
	"use strict";
	switch (action.type){

		default:
			return state;
	}
}
