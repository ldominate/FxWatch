import { Component } from "react";
import { connect } from "react-redux";

import NavigationNewsTabs from "./NavigationNewsTabs";

class NavigationNews extends Component{
	constructor(props){
		super(props);
	}

	render(){
		return (<div className="navigation-box">
			<NavigationNewsTabs />
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NavigationNews);