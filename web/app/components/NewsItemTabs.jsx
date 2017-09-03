import { Component } from "react";
import { connect } from "react-redux";

import PeriodNewsDataTabs from "./PeriodNewsDataTabs";
import NewsDataFintoolBox from "./NewsDataFintoolBox";

class NewsItemTabs extends Component{
	constructor(props){
		super(props);
	}

	render(){
		return (<div className="news-item-tabs">
			<div className="news-data-period-tabs">
				<PeriodNewsDataTabs/>
			</div>
			<NewsDataFintoolBox/>
		</div>);
	}
}

const mapStateToProps = (state) => ({});

const mapDispatchToProps = (dispatch) => ({});

export default connect(mapStateToProps, mapDispatchToProps)(NewsItemTabs);