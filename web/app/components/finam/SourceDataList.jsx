import * as React from "react";
import PropsTypes from "prop-types";
import ReactDOM from "react-dom";
import $ from "jquery";
import dxList from "devextreme/ui/list";

import { SourceType } from "../../sources/SourceLib";
import sourceCode, { SourceCodeParam } from "../../sources/SourceCodeSource";

class SourceDataList extends React.Component {
    constructor(props){
        super(props);
	    //console.log(this.props);
	    this.list = null;

	    const param = new SourceCodeParam(this.props.sourceType, this.props.sourceStamp);
	    param.loaded = this.loaded.bind(this);

        this.dataSource = sourceCode(param);
        this.state = {
        	isLoaded: false
        };
    }
    loaded(){
    	//console.log("loaded", this.state.isLoaded);
	    if(!this.state.isLoaded) {
		    this.setState({isLoaded: true});
	    }
    }
    shouldComponentUpdate(nextProps, nextState){
	    //this.list.dxList("instance").unselectAll();
	    //console.log(nextState);

	    return false;
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
				if(data.change >= 0){
					result.addClass("positive");
				}else{
					result.addClass("negative");
				}
		        // $("<div>").addClass("time-news").text(data.published.toLocaleTimeString("ru-RU", {
		        // 	month: "2-digit",
		        // 	day: "2-digit",
		        // 	year: "numeric",
		        // 	hour:"numeric",
		        // 	minute: "2-digit"})
		        // ).appendTo(result);
		        // $("<div>").html(`<span class="flag-icon flag-icon-${data.country_code.toLowerCase()}"></span>${data.countryCode}`)
		        // 	.appendTo(result);
		        const row1 = $("<div>").addClass("item-ttl");
		        $("<div>").addClass("code-name").html(data.name)
			        .appendTo(row1);
		        if(data.datetime !== null)
		            $("<div>").addClass("fin-time").html(data.datetime.toLocaleTimeString("ru-RU", { hour:"numeric", minute: "2-digit"}))
			            .appendTo(row1);

		        row1.appendTo(result);

		        if(data.change !== null) {
			        const row2 = $("<div>").addClass("item-data");
			        $("<div>").addClass("fin-change").html(data.max.toFixed(4))
				        .appendTo(row2);
			        $("<div>").addClass("fin-percent").html(`${data.percent.toFixed(2)}%`)
				        .appendTo(row2);
			        row2.appendTo(result);
		        }
		        return result;
	        },
	        nextButtonText: "Загрузить ещё...",
	        noDataText: "Данных нет",
	        //pageLoadMode: "scrollBottom",
	        //pageLoadingText: "Загрузка...",
	        pageLoadingText: "",
	        onSelectionChanged: e => {
	        	//console.log("selectionChanged", e);
	        	if(Array.isArray(e.addedItems) && e.addedItems.length){
	        		this.props.handleChangeTool(e.addedItems[0]);
		        }
	        },
	        onContentReady: e => {
	        	//console.log("content ready", e);
		        if(this.state.isLoaded)
			        this.list.dxList("instance").selectItem(0);
	        }
        }).dxList("instance");
    }
    render(){
        return <div className="list-source" />;
    }
}

SourceDataList.propTypes = {
	sourceType: PropsTypes.oneOf(SourceType.getTypes()).isRequired,
	sourceStamp: PropsTypes.number,
	handleChangeTool: PropsTypes.func.isRequired
};

export default SourceDataList;