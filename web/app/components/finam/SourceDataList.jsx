import { Component } from "react";
import ReactDOM from "react-dom";
import $ from "jquery";
import dxList from "devextreme/ui/list";

import sourceCode, { SourceCodeParam } from "../../sources/SourceCodeSource";

class SourceDataList extends Component {

    constructor(props){
        super(props);
	    //console.log(this.props);
	    this.list = null;
        this.dataSource = sourceCode(new SourceCodeParam(this.props.sourceType));
    }
    componentDidMount(){
        this.list = $(ReactDOM.findDOMNode(this));
        //console.log(dxList);
        //console.log(this.list);
        //console.log(this.list.dxList);
        this.list.dxList({
	        dataSource: this.dataSource,
	        selectionMode: "single",
	        showSelectionControls: false,
	        itemTemplate: function(data, index) {
		        const result = $("<div>").addClass("item-code");

		        // $("<div>").addClass("time-news").text(data.published.toLocaleTimeString("ru-RU", {
		        // 	month: "2-digit",
		        // 	day: "2-digit",
		        // 	year: "numeric",
		        // 	hour:"numeric",
		        // 	minute: "2-digit"})
		        // ).appendTo(result);
		        // $("<div>").html(`<span class="flag-icon flag-icon-${data.country_code.toLowerCase()}"></span>${data.countryCode}`)
		        // 	.appendTo(result);
		        $("<div>").html(data.name)
			        .appendTo(result);
		        return result;
	        },
	        nextButtonText: "Загрузить ещё...",
	        noDataText: "Новостей нет",
	        pageLoadMode: "scrollBottom",
	        pageLoadingText: "Загрузка...",
        });
    }
    render(){
        return <div className="list-source" />;
    }
}

export default SourceDataList;