import "core-js/es6/promise";
import "core-js/fn/promise";

import "whatwg-fetch";

export const SourceType = {
    CURRENCY_PAIRS: 0,
    FINANCIAL_INSTRUMENTS: 1,
    getTypes: () => [0, 1]
};

export function fetchUrl(url, getFirst = false) {

    return fetch(url, { method: 'get', credentials: "include" })
        .then(response => {
            //console.log(response);
            return response.json();
        }).then(json => {
            const result = json.map(d => {
                if(d.datetime !== null) {
                    d.datetime = new Date(d.datetime);
                }
                return d;
            });
            //console.log(result);
            return getFirst ? result[0] : result;
        }).catch(ex => {
            console.log("parsing failed", ex);
            return 0;
        });
}