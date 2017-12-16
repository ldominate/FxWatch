import React from "react";
import ReactDOM from "react-dom";
import "devextreme/integration/jquery";

import { SourceType } from "./sources/SourceLib";

import Finam from "./components/finam/Finam";

import "dxCommonCss";
import "dxDarkVioletCss";

import "./components/finam/finamChart.less";

// import sourceCode, { SourceCodeParam } from "./sources/SourceCodeSource";
// import finDataSource, { finDataSourceParam }  from "./sources/FinDataSource";
//
// const param = new SourceCodeParam(0);
// param.sourceCode = "usdrub";
//
// const sCodeSource = sourceCode(param);
// const fCodeSource = sourceCode(new SourceCodeParam(1));
//
// sCodeSource.byKey(param.sourceCode).then(result => console.log("t", typeof(result), result));
// sCodeSource.load().then(result => console.log("t", typeof(result), result));
// fCodeSource.load().then(result => console.log("t", typeof(result), result));
//
// finDataSourceParam.sourceCode = "usdrub";
//
// const finSource = finDataSource(() => finDataSourceParam);
// finSource.load().then(result => console.log("FinData", result));
//
// class User{
// 	name : string;
// 	age : number;
// 	constructor(_name:string, _age: number){
//
// 		this.name = _name;
// 		this.age = _age;
// 	}
// }
// var tom : User = new User("Том", 29);
// el.innerHTML = `Имя: ${tom.name} возраст: ${tom.age}`;

//console.log((new Date("2017-12-15T13:37:18+10:00")));

const FinamBox = () => <div id="finam-box">
	<Finam sourceType={SourceType.CURRENCY_PAIRS} sourceStamp={((new Date("2017-12-15T13:37:18+10:00")).getTime() / 1000)} />
	{/*<Finam sourceType={SourceType.FINANCIAL_INSTRUMENTS} />*/}
</div>;

ReactDOM.render(
	<FinamBox />,
	document.getElementById("widget")
);