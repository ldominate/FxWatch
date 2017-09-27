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
		this.params = {
			nid: this.props.nid,
			fid: this.props.fid,
			pid: this.props.pid
		};
		this.dataSource = NewsDataSource(this.getParams.bind(this));
	}
	getParams(){
		return this.params;
	}
	shouldComponentUpdate(nextProps, nextState) {
		//console.log(nextProps.nid, nextProps.fid, nextProps.pid);

		this.params = {
			nid: nextProps.nid,
			fid: nextProps.fid,
			pid: nextProps.pid
		};
		//this.dataSource.load();
		this.candle.dxChart("instance").beginUpdate();
		this.candle.dxChart("instance").option({
			dataSource: this.dataSource
		});
		this.candle.dxChart("instance").endUpdate();
		// this.candle.dxChart("instance").render({
		// 	force: true
		// });
		return false;
	}
	componentDidMount() {
		this.candle = $(ReactDOM.findDOMNode(this));
		this.candle.dxChart({
			// adaptiveLayout: {
			// 	height: 40,
			// 	keepLabels: true,
			// 	width: 60
			// },
			dataSource: this.dataSource,
			loadingIndicator: {
				show: true,
				text: "Загрузка..."
			},
			commonSeriesSettings: {
				argumentField: "datetime",
				type: "candlestick",
				label: {
					visible: true,
					backgroundColor: "rgba(0, 0, 0, 0)"
				},
				reduction: {
					color: "black",
					//level: "high"
				},
			},
			legend: {
				//itemTextPosition: 'left',
				visible: false
			},
			crosshair:{
				enabled: true,
				dashStyle: "dash"
			},
			series: {
				//name: "DELL",
				openValueField: "open",
				highValueField: "max",
				lowValueField: "min",
				closeValueField: "close",
				// reduction: {
				// 	color: "#000",
				// 	//level: null
				// },
				color: "#000",
				showInLegend: false
			},
			valueAxis: {
				valueType: "numeric",
				type: "continuous",
				//tickInterval: 0.0001,
				// title: {
				// 	text: ""
				// },
				// label: {
				// 	format: {
				// 		type: "fixedPoint",
				// 		precision: 4
				// 	}
				// },
				// max: 1.141,
				// min: 1.139,
			},
			argumentAxis: {
				argumentType: "datetime",
				label: {
					format: d => d.toLocaleTimeString("ru-RU", {
						hour:"numeric",
						minute: "2-digit",
						formatMatcher: "basic"
					})
				},
				type: "discrete",
				valueMarginsEnabled: true,
				maxValueMargin: 0,
				minValueMargin: 0
				// max: new Date("2017-07-12T00:00:00"),
				// min: new Date("2017-07-12T04:05:00")
			},
			"export": {
				enabled: false
			},
			tooltip: {
				enabled: true,
				location: "edge",
				customizeTooltip: function (arg) {
					console.log(arg);
					return {
						text: `Откр.: ${arg.openValue}<br/>Мин.: ${arg.lowValue}<br/>Макс.: ${arg.highValue}<br/>Закр.: ${arg.closeValue}<br/>Время: ${arg.originalArgument.toLocaleTimeString("ru-RU", {
							hour:"numeric",
							minute: "2-digit",
							formatMatcher: "basic"
						})}`
					};
				}
			},
			customizeLabel: pointInfo => {
				//console.log(pointInfo);
				const vis = pointInfo.argument.getTime() === this.props.published.getTime();
				//if(pointInfo.argument.getTime() !== this.props.published.getTime()){
					// console.log(pointInfo);
					// console.log(this.props.published);
					// console.log(pointInfo.argument.getTime(), this.props.published.getTime());
					//return null;
					// return {
					// 	//position: "outside",
					// 	//verticalOffset: 2,
					// 	visible: true,
					// 	// customizeText: () => {
					// 	// 	return "D";
					// 	// }
					// };
				//}
				let val = null;
				if (vis && pointInfo.closeValue < pointInfo.openValue) {
					val = (pointInfo.lowValue - pointInfo.openValue) * 10000.0;
					//console.log(val);
					//alert(this.highValue);
					// return {
					// 	visible: false,
					// 	customizeText: () => {
					// 		return "";
					// 	}
					// };
				}else if( vis && pointInfo.closeValue > pointInfo.openValue){
					val = (pointInfo.highValue - pointInfo.openValue) * 10000.0;
					//console.log(val);
					// return {
					// 	position: "outside",
					// 	visible: true,
					// 	format: {
					// 		type: "fixedPoint",
					// 		precision: 4,
					// 		percentPrecision: 2
					// 	},
					// 	verticalOffset: 1,
					// 	// argumentFormat: {
					// 	// 	type: "fixedPoint",
					// 	// 	argumentPrecision: 5
					// 	// },
					// 	customizeText: function() {
					// 		//console.log("Close");
					// 		//return val;
					// 		//return "C";
					// 		return val.toLocaleString("en-US", {
					// 		 	maximumFractionDigits: 15
					// 		});
					// 	}
					// }
				}
				return {
					position: "outside",
					visible: val || false,
					format: {
						type: "fixedPoint",
						precision: 4,
						percentPrecision: 2
					},
					font: {
						size: 10,
						//color: (val > 0) ? "#449d44": "#c9302c"
					},
					//border: {
					// 	color: "#449d44",
					// 	visible: false,
					// 	width: 1
					//},
					backgroundColor: (val > 0) ? "#449d44": "#c9302c",
					//backgroundColor: "rgba(0, 0, 0, 0)",
					//verticalOffset: 1,
					// argumentFormat: {
					// 	type: "fixedPoint",
					// 	argumentPrecision: 5
					// },
					customizeText: function() {
						if(val !== null){
							return `${val >= 0 ? "+" : ""}${val.toLocaleString("en-US", {
								maximumFractionDigits: 2
							})}`;
						}
						//console.log("Open");
						//return "O";
						//return val;
						//return "▲"+"\n$" + this.valueText;
						return null;
					}
				};
				// else{
				// 	console.log("Nothing");
				// 	return {
				// 		visible: true,
				// 		customizeText: function() {
				// 			return "N";
				// 		}
				// 	};
				// }
				// return {
				// 	//position: "outside",
				// 	visible: false,
				// 	customizeText: () => {
				// 		return null;
				// 	}
				// };
			}
		}).dxChart("instance");
	}
	render(){
		return (<div className="candle-stick" />);
	}
}

const mapStateToProps = (state, ownProps) => ({
	nid: state.getIn(["graphs", ownProps.index, "news", "id"]),
	fid: state.getIn(["graphs", ownProps.index, ownProps.side, "fintool"]),
	pid: state.getIn(["graphs", ownProps.index, ownProps.side, "period"]),
	published: state.getIn(["graphs", ownProps.index, "news", "published"])
});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(CandleStick);