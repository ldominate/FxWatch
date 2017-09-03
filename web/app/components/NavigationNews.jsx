import { Component } from "react";
import { connect } from "react-redux";

import NavigationNewsTabs from "./NavigationNewsTabs";
import NavigationNewsList from "./NavigationNewsList";

class NavigationNews extends Component{
	constructor(props){
		super(props);
	}

	render(){
		return (<div className="navigation-box">
			<NavigationNewsTabs />
			<NavigationNewsList />
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNews);