/**
 * Created by johny on 26.08.2017.
 */
import React from "react";
import ReactDOM from "react-dom";
import { Provider } from "react-redux";
import { createStore } from "redux";
import { fromJS } from "immutable";
import { initSate } from "./actions/ReducerWidget";
import Reducer from "./actions/ReducerWidget";
import Widget from "./components/Widget";

import "dxCommonCss";
import "dxLightCss";

const store = createStore(Reducer, fromJS(initSate()));

ReactDOM.render(
	<Provider store={store}>
		<Widget />
	</Provider>,
	document.getElementById("widget")
);