import * as React from "react";
import PropsTypes from "prop-types";

import { SourceType } from "../../sources/SourceLib";
import SourceDataList from "./SourceDataList";
import FinInfo from "./FinInfo";
import FinChart from "./FinChart";

class Finam extends React.Component{
    state = {
        tool: {
        	code: "",
	        name: "",
	        change: .0,
	        percent: .0,
	        max: .0
        }
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
            <div className="chart-box">
	            <FinInfo {...this.state.tool}/>
	            {this.state.tool.code.length > 0
		            ? <FinChart sourceCode={this.state.tool.code} sourceStamp={this.props.sourceStamp}/>
		            : null
	            }
            </div>
        </div>;
    }
}

Finam.propsTypes = {
	sourceType: PropsTypes.oneOf(SourceType.getTypes()).isRequired,
	sourceStamp: PropsTypes.number
};

export default Finam;