import * as React from "react";
import PropsTypes from "prop-types";

const FinInfo = props => <div className="fin-info-box dx-widget">
	<div className="info-name">{props.name}</div>
	<div className="info-value">{props.max.toFixed(4)}</div>
	<div className={`info-change${(props.change >= 0 ? " positive" : " negative")}`}>
		{`${props.change.toFixed(4)}/${props.percent.toFixed(2)}%`}
	</div>
</div>;

FinInfo.propTypes = {
	name: PropsTypes.string,
	change: PropsTypes.number,
	percent: PropsTypes.number,
	max: PropsTypes.number
};

export default FinInfo