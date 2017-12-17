import React from "react";
import ReactDOM from "react-dom";
import "devextreme/integration/jquery";

import { SourceType } from "./sources/SourceLib";

import Finam from "./components/finam/Finam";

import "dxCommonCss";
import "dxDarkVioletCss";

import "./components/finam/finamChart.less";

const FinamBox = () => <div id="finam-box">
	<Finam
		sourceType={SourceType.CURRENCY_PAIRS}
		defaultCode="EURUSD"
//		sourceStamp={((new Date("2017-12-14T10:37:18+10:00")).getTime() / 1000)}
		sourceStamp={Math.round(Date.now() / 1000)}
	/>
	<Finam
		sourceType={SourceType.FINANCIAL_INSTRUMENTS}
		defaultCode="SANDP-500"
//		sourceStamp={((new Date("2017-12-14T10:37:18+10:00")).getTime() / 1000)}
		sourceStamp={Math.round(Date.now() / 1000)}
	/>
</div>;

ReactDOM.render(
	<FinamBox />,
	document.getElementById("widget")
);