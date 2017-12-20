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
		this.dataSource = finData;
		this.setMin = false;
	}
	putParam(){
		return this.param;
	}
	shouldComponentUpdate(nextProps, nextState){
		//console.log("update", nextProps);
		finDataSourceParam.sourceCode = nextProps.sourceCode;
		finDataSourceParam.timeStamp = nextProps.sourceStamp;
		this.param = finDataSourceParam;

		const instance = this.chart.dxChart("instance");

		const source = instance.getDataSource();
		instance.showLoadingIndicator();
		source.reload().done(result => {
			//console.log(result);
			this.setMin = false;
			instance.option({valueAxis: { min: .0 }});
		});

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
			//commonPaneSettings: {
			//	backgroundColor: "#0FAD51"
			//	backgroundColor: "rgba(255, 155, 255, 0.5)"
			//},
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
				visible: false
			},
			crosshair:{
				enabled: true,
				dashStyle: "dash"
			},
			series:[ {
					valueField: "max",
					hoverMode: "none",
					color: "#22BFB8",
					showInLegend: false
				},
				{
					valueField: "max",
					hoverMode: "none",
					color: "#22BFB8",
					showInLegend: false,
					type: 'area'
				}
			],
			valueAxis: {
				valueType: "numeric",
				type: "continuous",
				label: {
				},
				grid: {
					visible: true
				},
				position: "right"
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
			},
			panes: {
				border: {
					top: false,
					left: false,
					visible: true,
					width: 2
				}
			},
			// tooltip: {
			// 	enabled: true
			// },
			export: {
				enabled: false
			},
			onDone: e => {
				//console.log("done", e);
				if(this.setMin) return;
				const series = this.chart.dxChart("instance").getAllSeries();
				//console.log(series);
				let min = .0;
				if(Array.isArray(series) && series.length > 1){
					series[0].getAllPoints().forEach((p, i) => {
						if(p.originalValue < min || min === .0) min = p.originalValue;
					});
				}
				if(min > .0){
					//console.log("min", min);
					this.chart.dxChart("instance").option({valueAxis: { min: min }});
				}
				this.setMin = true;
			}
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
