import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxChart from "devextreme/viz/chart";

import NewsDataSource from "../sources/NewsDataSource";

class CandleStick extends Component{
	constructor(props){
		super(props);
		this.candle = null;
	}
	componentDidMount() {
		this.dropDown = $(ReactDOM.findDOMNode(this));
		this.dropDown.dxChart({
			// adaptiveLayout: {
			// 	height: 40,
			// 	keepLabels: true,
			// 	width: 60
			// },
			dataSource: NewsDataSource(() => ({nid: 3, fid: 1, pid: 1})),
			commonSeriesSettings: {
				argumentField: "datetime",
				type: "candlestick"
			},
			legend: {
				itemTextPosition: 'left',
				visible: false
			},
			series: [
				{
					name: "DELL",
					openValueField: "open",
					highValueField: "max",
					lowValueField: "min",
					closeValueField: "close",
					reduction: {
						color: "red"
					}
				}
			],
			valueAxis: {
				//tickInterval: 0.0001,
				// title: {
				// 	text: ""
				// },
				// label: {
				// 	format: {
				// 		type: "currency",
				// 		precision: 0
				// 	}
				// },
				// max: 1.141,
				// min: 1.139,
			},
			argumentAxis: {
				label: {
					format: d => d.toLocaleDateString("ru-RU", {
						month: "2-digit",
						day: "2-digit",
						year: "2-digit",
						formatMatcher: "basic"
					})
				}
			},
			"export": {
				enabled: false
			},
			tooltip: {
				enabled: true,
				location: "edge",
				customizeTooltip: function (arg) {
					return {
						text: `Откр.: ${arg.openValue}<br/>Мин.: ${arg.lowValue}<br/>Макс.: ${arg.highValue}<br/>Закр.: ${arg.closeValue}`
					};
				}
			}
		});
	}
	render(){
		return (<div className="candle-stick" />);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(CandleStick);