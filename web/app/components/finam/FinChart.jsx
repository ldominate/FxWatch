import * as React from "react";
import PropsTypes from "prop-types";
import ReactDOM from "react-dom";
import $ from "jquery";
import dxChart from "devextreme/viz/chart";

import finData, {finDataSourceParam} from "../../sources/FinDataSource";

class FinChart extends React.Component {
	constructor(props){
		super(props);
		this.chart = null;

		this.param = finDataSourceParam;
		this.dataSource = finData;//(this.putParam.bind(this));
	}
	putParam(){
		return this.param;
	}
	shouldComponentUpdate(nextProps, nextState){
		//this.list.dxList("instance").unselectAll();
		console.log(nextProps);
		finDataSourceParam.sourceCode = nextProps.sourceCode;
		finDataSourceParam.timeStamp = nextProps.sourceStamp;
		this.param = finDataSourceParam;

		const instance = this.chart.dxChart("instance");

		instance.beginUpdate();
		instance.option({
			dataSource: this.dataSource(this.putParam.bind(this))
		});
		instance.endUpdate();

		return false;
	}
	componentDidMount(){
		finDataSourceParam.sourceCode = this.props.sourceCode;
		finDataSourceParam.timeStamp = this.props.sourceStamp;
		this.param = finDataSourceParam;
		this.chart = $(ReactDOM.findDOMNode(this));
		this.chart.dxChart({
			dataSource: this.dataSource(this.putParam.bind(this)),
			loadingIndicator: {
				show: true,
				text: "Загрузка..."
			},
			commonSeriesSettings: {
				argumentField: "datetime",
				type: "line",
				label: {
					visible: false,
					//backgroundColor: "rgba(0, 0, 0, 0)"
				},
				// reduction: {
				// 	color: "black",
				// 	//level: "high"
				// },
				point: {
					visible: false
				}
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
				valueField: "max",

				// openValueField: "open",
				// highValueField: "max",
				// lowValueField: "min",
				// closeValueField: "close",
				// reduction: {
				// 	color: "#000",
				// 	//level: null
				// },
				//color: "#000",
				showInLegend: false
			},
			valueAxis: {
				valueType: "numeric",
				type: "continuous",
				//tickInterval: 0.0001,
				// title: {
				// 	text: ""
				// },
				label: {
					customizeText: axisValue => {
						return axisValue.value.toFixed(4);
					},
					//alignment: "right"
					// 	format: {
					// 		type: "fixedPoint",
					// 		precision: 4
					// 	}
				},
				grid: {
					visible: true
				},
				position: "right"
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
				grid: {
					visible: true
				}
				//type: "discrete",
				//valueMarginsEnabled: true,
				//maxValueMargin: 0,
				//minValueMargin: 0
				// max: new Date("2017-07-12T00:00:00"),
				// min: new Date("2017-07-12T04:05:00")
			},
			"export": {
				enabled: false
			},
		});
	}
	render(){
		return <div className="chart" />;
	}
}

FinChart.propTypes = {
	sourceCode: PropsTypes.string.isRequired,
	sourceStamp: PropsTypes.number.isRequired,
};

export default FinChart;
