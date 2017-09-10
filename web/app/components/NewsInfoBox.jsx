import { Component } from "react";
//import ReactDOM from "react-dom";
import { connect } from "react-redux";

class NewsInfoBox extends Component{
	constructor(props){
		super(props);
	}
	render(){
		//console.log(this.props.news.published);
		const published = new Date(this.props.news.published);
		const newsInfo = (this.props.news.id > 0) ?`${this.props.news.categorynews} от ${published.toLocaleString("ru-RU", {
			month: "2-digit",
			day: "2-digit",
			year: "numeric",
			hour:"numeric",
			minute: "2-digit",
			formatMatcher: "basic"})}` : "";
		return (
			<div className="news-info-title">{newsInfo}</div>
		);
	}
}

const mapStateToProps = (state) => ({
	news: state.get("news").toJSON()
});

const mapDispatchToProps = (dispatch) => ({
	selectCountry: (e) => dispatch(selectCountry(e.value))
});

export default connect(mapStateToProps, mapDispatchToProps)(NewsInfoBox);