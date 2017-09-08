import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";
import $ from "jquery";
import dxSelectBox from "devextreme/ui/select_box";

import CountrySource from "../sources/CountrySource";

import {selectCountry} from "../actions/ActionsWidget";

class SelectCountryBox extends Component{
	constructor(props){
		super(props);
		this.selectBox = null;
	}
	shouldComponentUpdate(nextProps, nextState) {
		this.selectBox.dxSelectBox("instance").option({
			value: nextProps.value
		});
		return false;
	}
	componentDidMount(){
		this.selectBox = $(ReactDOM.findDOMNode(this));
		this.selectBox.dxSelectBox({
			dataSource: CountrySource.getStore(),
			fieldTemplate: function(data, container) {
				if(!data) data = {code: "", text: ""};
				//console.log(data);
				const result = $(`<div class='custom-item'>
				<div class="flag-icon flag-icon-${data.code.toLowerCase()}"></div>
				<div class="product-name"></div>
				</div>`);
				result
					.find(".product-name")
					.dxTextBox({
						value: data.text,
						readOnly: true
					});
				container.append(result);
			},
			//displayExpr: "text",
			value: this.props.value,
			valueExpr: "code",
			itemTemplate: function(data) {
				return `<div class="custom-item">
						<span class="flag-icon flag-icon-${data.code.toLowerCase()}"></span>
						<span class="product-name">${data.text}</span>
						</div>`;
			},
			onValueChanged: this.props.selectCountry,
			placeholder: "Выберите страну..."
		}).dxSelectBox("instance");
	}
	render(){
		return (<div className="select-country" />);
	}
}

const mapStateToProps = (state) => ({
	value: state.getIn(["newsList", "country"])
});

const mapDispatchToProps = (dispatch) => ({
	selectCountry: (e) => dispatch(selectCountry(e.value))
});

export default connect(mapStateToProps, mapDispatchToProps)(SelectCountryBox);