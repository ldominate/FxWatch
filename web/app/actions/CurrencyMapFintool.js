export function getSidesFintool(currency){
	"use strict";
	const map = {
		"EUR": { left: "EURUSD", right: "EURJPY" },
		"USD": { left: "USDCHF", right: "USDJPY" },
		"GBP": { left: "GBPUSD", right: "GBPJPY" },
		"JPY": { left: "USDJPY", right: "EURJPY" },
		"CHF": { left: "USDCHF", right: "EURCHF" },
		"CAD": { left: "USDCAD", right: "EURCAD" },
		"AUD": { left: "AUDUSD", right: "AUDJPY" },
		"NZD": { left: "NZDUSD", right: "NZDJPY" },
		"CNY": { left: "AUDUSD", right: "NZDUSD" }
	};
	if(currency in map) {
		return map[currency];
	}
	return map.EUR;
}
