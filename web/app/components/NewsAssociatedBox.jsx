import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxDataGrid from "devextreme/ui/data_grid";

import NewsAssociatedSource from "../sources/NewsAssociatedSource";

class NewsAssociatedBox extends Component{
	constructor(props){
		super(props);
		this.grid = null;
		this.paramF = () => ({nid: this.props.nid});
	}
	shouldComponentUpdate(nextProps, nextState) {
		this.paramF = () => ({nid: nextProps.nid});
		console.log(this.grid.dxDataGrid("instance").totalCount());
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
					dataType: "date"
				},{
					dataField: "currency_code",
					caption: "Валюта",
					dataType: "string"
				},{
					dataField: "release",
					caption: "Публикация",
					dataType: "string"
				},{
					dataField: "influence",
					caption: "Влияние",
					dataType: "string"
				},{
					dataField: "fact",
					caption: "Факт",
					dataType: "number"
				},{
					dataField: "forecast",
					caption: "Прогноз",
					dataType: "number"
				},{
					dataField: "deviation",
					caption: "Отклонение",
					dataType: "number"
				},{
					dataField: "previous",
					caption: "Предыдущее",
					dataType: "number"
			}],
			remoteOperations: {
				paging: true
			},
			paging: {
				pageSize: 6
			},
			// pager: {
			// 	showPageSizeSelector: true,
			// 	allowedPageSizes: [7, 14, 30]
			// },
			height: 160,
			loadPanel: {
				enabled: true
			},
			scrolling: {
			 	mode: "virtual"
			},
			sorting: {
				mode: "none"
			}
		}).dxDataGrid("instance");
	}
	render(){
		return (<div className="associated-news-box" />);
	}
}


const mapStateToProps = (state) => ({
	nid: state.getIn(["news", "id"])
});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NewsAssociatedBox);