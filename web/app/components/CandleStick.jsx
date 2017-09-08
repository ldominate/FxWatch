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
	shouldComponentUpdate(nextProps, nextState) {
		console.log(nextProps.nid, nextProps.fid, nextProps.pid);
		//this.candle.dxChart("instance").render();
		this.candle.dxChart("instance").beginUpdate();
		this.candle.dxChart("instance").option({
			dataSource: NewsDataSource(() => ({
				nid: nextProps.nid,
				fid: nextProps.fid,
				pid: nextProps.pid
			}))
		});
		this.candle.dxChart("instance").endUpdate();
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
			dataSource: NewsDataSource(() => ({
				nid: this.props.nid,
				fid: this.props.fid,
				pid: this.props.pid
			})),
			loadingIndicator: {
				show: true,
				text: "Загрузка..."
			},
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
					format: d => d.toLocaleTimeString("ru-RU", {
						hour:"numeric",
						minute: "2-digit",
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
		}).dxChart("instance");
	}
	render(){
		return (<div className="candle-stick" />);
	}
}

const mapStateToProps = (state, ownProps) => ({
	nid: state.getIn(["news", "id"]),
	fid: state.getIn([ownProps.side, "fintool"]),
	pid: state.getIn([ownProps.side, "period"])
});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(CandleStick);