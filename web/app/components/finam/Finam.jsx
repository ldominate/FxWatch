import { Component } from "react";
import PropsTypes from "prop-types";

import { SourceType } from "../../sources/SourceLib";
import SourceDataList from "./SourceDataList";


class Finam extends Component{
    state = {
        value: ""
    };
    render(){
        return <div className="finam-chart">
            <div className="navigation-box">
                <SourceDataList sourceType={this.props.sourceType} sourceStamp={this.props.sourceStamp}/>
            </div>
            <div className="chart-box">Cart Box</div>
        </div>;
    }
}

Finam.propsTypes = {
	sourceType: PropsTypes.oneOf(SourceType.getTypes()).isRequired,
	sourceStamp: PropsTypes.number
};

export default Finam;