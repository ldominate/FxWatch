export const LOCATION_PROTOCOL = "http:";
//export const LOCATION_HOST = "fxwatch";
//export const LOCATION_HOST = "fx-chart.foshan.tours";
export const LOCATION_HOST = 'widget.fxwatch.ru';

export function wrapHost(relativeUrl){
	const lastSep = relativeUrl.charAt(0) === "\/" ? "" : "\/";
	return LOCATION_PROTOCOL.concat("//", LOCATION_HOST, lastSep, relativeUrl);
}