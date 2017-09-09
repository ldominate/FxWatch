import { Component } from "react";
import ReactDOM from "react-dom";
import { connect } from "react-redux";
import $ from "jquery";
import dxTextBox from "devextreme/ui/text_box";

import {searchNews} from "../actions/ActionsWidget";

class SearchNewsBox extends Component{
	constructor(props){
		super(props);
		this.searchBox = null;
	}
	componentDidMount(){
		this.searchBox = $(ReactDOM.findDOMNode(this));
		this.searchBox.dxTextBox({
			value: this.props.search,
			valueChangeEvent: "keyup",
			placeholder: "Поиск",
			onValueChanged: this.props.searchNews,
			mode: "search"
		}).dxTextBox("instance");
	}
	render(){
		return (<div className="search-box" />);
	}
}

const mapStateToProps = (state) => ({
	search: state.getIn(["newsList", "search"])
});

const mapDispatchToProps = (dispatch) => ({
	searchNews: (e) => dispatch(searchNews(e.value))
});

export default connect(mapStateToProps, mapDispatchToProps)(SearchNewsBox);