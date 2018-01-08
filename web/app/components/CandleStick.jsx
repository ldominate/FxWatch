import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxChart from "devextreme/viz/chart";

import CatalogFintoolGroupSource from "../sources/CatalogFintoolGroupSource";
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
		this.dataSource.on("loaded", this.loadedSeries.bind(this));
		this.fintoolGroupSource = CatalogFintoolGroupSource.getStore();
		this.labelCoef = 10000.0;
		this.fintoolGroupSource.byKey(this.props.fid)
			.done(d => {this.labelCoef = d.name.indexOf("JPY") >= 0 ? 100000.0 : 10000.0;});
		this.publishedTime = this.props.published.getTime();
	}
	getParams(){
		return this.params;
	}
	loadedSeries(result){
		//console.log(result);
		if(Array.isArray(result)){
			let prev = null;
			result.forEach((val, index) => {
				const vTime = val.datetime.getTime();
				if(vTime > this.publishedTime){
					this.publishedTime = prev;
				} else {
					prev = vTime;
				}
			});
		}
	}
	shouldComponentUpdate(nextProps, nextState) {
		//console.log(nextProps.nid, nextProps.fid, nextProps.pid);
		this.fintoolGroupSource.byKey(nextProps.fid)
			.done(d => {this.labelCoef = d.name.indexOf("JPY") >= 0 ? 100000.0 : 10000.0;});

		this.publishedTime = nextProps.published.getTime();;

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

		return false;
	}
	componentDidMount() {
		this.candle = $(ReactDOM.findDOMNode(this));
		this.candle.dxChart({
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
				},
			},
			legend: {
				visible: false
			},
			crosshair:{
				enabled: true,
				dashStyle: "dash"
			},
			series: {
				openValueField: "open",
				highValueField: "max",
				lowValueField: "min",
				closeValueField: "close",
				color: "#000",
				showInLegend: false
			},
			valueAxis: {
				valueType: "numeric",
				type: "continuous",
				label: {
					customizeText: axisValue => {
						return axisValue.value.toFixed(4);
					}
				},
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
			},
			"export": {
				enabled: false
			},
			tooltip: {
				enabled: true,
				location: "edge",
				customizeTooltip: function (arg) {
					//console.log(arg);
					return {
						html: `<table class="tipTab">
<tbody>
<tr><td>Время:</td><td>${arg.originalArgument.toLocaleTimeString("ru-RU", {hour:"numeric",minute: "2-digit",formatMatcher: "basic"})}</td></tr>
<tr><td>Откр.:</td><td>${arg.openValue.toFixed(4)}</td></tr>
<tr><td>Мин.:</td><td>${arg.lowValue.toFixed(4)}</td></tr>
<tr><td>Макс.:</td><td>${arg.highValue.toFixed(4)}</td></tr>
<tr><td>Закр.:</td><td>${arg.closeValue.toFixed(4)}</td></tr>
</tbody>
</table>`
					};
				}
			},
			customizeLabel: pointInfo => {
				//console.log(pointInfo, this.params);
				//console.log("labelCoef", this.labelCoef);
				const vis = pointInfo.argument.getTime() === this.publishedTime;
				let val = null;
				if (vis && pointInfo.closeValue < pointInfo.openValue) {
					val = (pointInfo.lowValue - pointInfo.openValue) * this.labelCoef;
				}else if( vis && pointInfo.closeValue > pointInfo.openValue){
					val = (pointInfo.highValue - pointInfo.openValue) * this.labelCoef;
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
					},
					backgroundColor: (val > 0) ? "#449d44": "#c9302c",
					customizeText: function() {
						if(val !== null){
							return `${val >= 0 ? "+" : ""}${val.toLocaleString("en-US", {
								maximumFractionDigits: 2
							})}`;
						}
						return null;
					}
				};
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