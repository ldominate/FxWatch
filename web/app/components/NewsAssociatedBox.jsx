import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxDataGrid from "devextreme/ui/data_grid";

import { selectAssociatedNews } from "../actions/ActionsWidget";

import NewsAssociatedSource from "../sources/NewsAssociatedSource";

class NewsAssociatedBox extends Component{
	constructor(props){
		super(props);
		this.grid = null;
		this.paramF = () => ({nid: this.props.nid});
	}
	shouldComponentUpdate(nextProps, nextState) {
		this.paramF = () => ({nid: nextProps.nid});
		//console.log(this.grid.dxDataGrid("instance").totalCount());
		this.grid.dxDataGrid("instance").refresh();
		// this.grid.dxDataGrid("instance").beginUpdate();
		// this.grid.dxDataGrid("instance").option({
		// 	dataSource: {
		// 		store: NewsAssociatedSource(() => ({nid: nextProps.nid}))
		// 	}
		// });
		// this.grid.dxDataGrid("instance").endUpdate();
		return false;
	}
	componentDidMount() {
		this.grid = $(ReactDOM.findDOMNode(this));
		this.grid.dxDataGrid({
			dataSource: {
				store: NewsAssociatedSource(this.paramF)
			},
			columns: [{
					dataField: "published",
					caption: "Дата и время",
					dataType: "date",
					width: 120,
					calculateCellValue: rowData => {
						return rowData.published.toLocaleString("ru-RU", {
							month: "2-digit",
							day: "2-digit",
							year: "numeric",
							hour:"numeric",
							minute: "2-digit",
							formatMatcher: "basic"});
					}
				},{
					dataField: "currency_code",
					caption: "Валюта",
					dataType: "string",
					cssClass: "columns currency",
					width: 60
				},{
					dataField: "release",
					caption: "Публикация",
					dataType: "string"
				},{
					dataField: "influence",
					caption: "Влияние",
					dataType: "string",
					width: 75
				},{
					dataField: "fact",
					caption: "Факт",
					dataType: "string",
					cssClass: "columns num-value",
					width: 70,
					calculateCellValue: rowData => {
						return (rowData.percent_value) ? `${rowData.fact}%` : rowData.fact;
					}
				},{
					dataField: "forecast",
					caption: "Прогноз",
					dataType: "string",
					cssClass: "columns num-value",
					width: 70,
					calculateCellValue: rowData => {
						return (rowData.percent_value) ? `${rowData.forecast}%` : rowData.forecast;
					}
				},{
					dataField: "deviation",
					caption: "Отклонение",
					dataType: "string",
					cssClass: "columns num-value",
					width: 70,
					calculateCellValue: rowData => {
						return (rowData.percent_value) ? `${rowData.deviation}%` : rowData.deviation;
					}
				},{
					dataField: "previous",
					caption: "Предыдущее",
					dataType: "string",
					cssClass: "columns num-value",
					width: 70,
					calculateCellValue: rowData => {
						return (rowData.percent_value) ? `${rowData.previous}%` : rowData.previous;
					}
			}],
			remoteOperations: {
				paging: true
			},
			paging: {
				pageSize: 6
			},
			//rowAlternationEnabled: true,
			showRowLines: true,
			hoverStateEnabled: true,
			selection: {
				mode: "single"
			},
			// pager: {
			// 	showPageSizeSelector: true,
			// 	allowedPageSizes: [7, 14, 30]
			// },
			height: 160,
			loadPanel: {
				enabled: true,
				text: "Загрузка...",
				showPane: false
			},
			noDataText: "Нет данных",
			scrolling: {
			 	mode: "virtual"
			},
			sorting: {
				mode: "none"
			},
			onSelectionChanged: this.props.selectNews
		}).dxDataGrid("instance");
	}
	render(){
		return (<div className="associated-news-box" />);
	}
}

const mapStateToProps = (state, ownProps) => ({
	nid: state.getIn(["news", "id"])
});

const mapDispatchToProps = (dispatch) => ({
	selectNews: (selectedItems) => {
		//console.log(selectedItems);
		return dispatch(selectAssociatedNews(selectedItems.selectedRowsData[0]))
	}
});

export default connect(mapStateToProps, mapDispatchToProps)(NewsAssociatedBox);