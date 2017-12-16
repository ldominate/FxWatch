import * as React from "react";
import PropsTypes from "prop-types";

import { SourceType } from "../../sources/SourceLib";
import SourceDataList from "./SourceDataList";



class Finam extends React.Component{
    state = {
        tool: null
    };
    changeTool(tool){
    	console.log("changeTool");
        this.setState({...this.state, tool: tool});
    }
    render(){
        return <div className="finam-chart">
            <div className="navigation-box">
                <SourceDataList
                    sourceType={this.props.sourceType}
                    sourceStamp={this.props.sourceStamp}
                    handleChangeTool={this.changeTool.bind(this)}
                />
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