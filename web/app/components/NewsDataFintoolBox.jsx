import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";

import $ from "jquery";
import dxDropDownBox from "devextreme/ui/drop_down_box";
import dxTreeView from "devextreme/ui/tree_view";

import CatalogFintoolGroupSource from "../sources/CatalogFintoolGroupSource";

class NewsDataFintoolBox extends Component{
	constructor(props){
		super(props);
		this.dropDown = null;
		this.contentValue = null;
		this.treeView = null;
	}
	componentDidMount(){
		this.dropDown = $(ReactDOM.findDOMNode(this));
		this.dropDown.dxDropDownBox({
			value: 1,
			valueExpr: "id",
			displayExpr: "name",
			placeholder: "Выберите значение...",
			showClearButton: false,
			deferRendering: false,
			dropDownOptions: {
				width: 200,
				height: 300,
			},
			//dataSource: fingroups,
			//opened: true,
			dataSource: CatalogFintoolGroupSource.getStore(),
			contentTemplate: this.contentTemplate
		});
	}
	contentTemplate(e){
		this.contentValue = e.component.option("value");
		const $treeView = $("<div>").dxTreeView({
			dataSource: e.component.option("dataSource"),
			//items: e.component.option("items"),
			//dataStructure: "plain",
			keyExpr: "id",
			parentIdExpr: "categoryId",
			selectionMode: "single",
			displayExpr: "name",
			selectByClick: true,
			itemsExpr: "fintools",
			//width: 200,
			//height: 300,
			onContentReady: this.contentReady,
			selectNodesRecursive: false,
			onItemSelectionChanged: (args) => {
				const value = args.component.getSelectedNodesKeys();

				e.component.option("value", value);
			}
		});

		this.treeView = $treeView.dxTreeView("instance");

		e.component.on("valueChanged", this.componentOnValueChanged);

		return $treeView;
	}
	contentReady(args){
		this.syncTreeViewSelection(args.component, this.contentValue);
	}
	componentOnValueChanged(args){
		this.syncTreeViewSelection(this.treeView, args.value);
	}
	syncTreeViewSelection(treeView, value) {
		if (!value) {
			treeView.unselectAll();
		} else {
			treeView.selectItem(value);
		}
	}
	render(){
		return (<div className="news-data-fintool-box" />);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NewsDataFintoolBox);