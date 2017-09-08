import { Component } from "react";
import { connect } from "react-redux";

import NavigationNewsTabs from "./NavigationNewsTabs";
import NavigationNewsListWeek from "./NavigationNewsListWeek";
import NavigationNewsListRegion from "./NavigationNewsListRegion";

import { NEWS_SOURCE_WEEK, NEWS_SOURCE_REGION, NEWS_SOURCE_SEARCH } from "../actions/ActionsWidget"

class NavigationNews extends Component{
	constructor(props){
		super(props);
	}

	render(){
		let navNewsList = null;
		switch(this.props.sourceNews) {
			case NEWS_SOURCE_REGION:
				navNewsList = <NavigationNewsListRegion />;
				break;
			case NEWS_SOURCE_WEEK:
			default:
				navNewsList = <NavigationNewsListWeek />;
		}
		return (<div className="navigation-box">
			<NavigationNewsTabs />
			{navNewsList}
		</div>);
	}
}

const mapStateToProps = (state) => ({
	sourceNews: state.getIn(["newsList", "sourceNews"])
});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNews);