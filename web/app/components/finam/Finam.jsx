import { Component } from "react";

import SourceDataList from "./SourceDataList";


class Finam extends Component{
    state = {
        value: ""
    };
    render(){
        return <div className="finam-chart">
            <div className="navigation-box">
                <SourceDataList sourceType={this.props.sourceType}/>
            </div>
            <div className="chart-box">Cart Box</div>
        </div>;
    }
}

export default Finam;