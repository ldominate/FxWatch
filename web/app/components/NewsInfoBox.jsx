import { Component } from "react";
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
			formatMatcher: "basic"})}` : <span>&nbsp;</span>;
		return (
			<div className="news-info-title">{newsInfo}</div>
		);
	}
}

const mapStateToProps = (state, ownProps) => {
	// console.log(ownProps);
	// console.log(state.getIn(["graphs", ownProps.index]));
	return {
	news: state.getIn(["graphs", ownProps.index, "news"]).toJSON()
}};

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NewsInfoBox);