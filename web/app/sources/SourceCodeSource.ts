import CustomStore from "devextreme/data/custom_store";

import * as $ from "jquery";

export class SourceCodeParam {

    constructor(sType: number){
        this.sourceType = sType;
        this.timeStamp = Math.round(Date.now() / 1000);
    }

    sourceType: number;

    timeStamp: number;
}

export default (scParam: SourceCodeParam) : CustomStore => {
    return new CustomStore({
        load: loadOption => {

            const url: string = `/finam/tools/${scParam.sourceType}/${scParam.timeStamp}`;

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
                    return result;
                }).catch(ex => {
                    console.log("parsing failed", ex);
                    return 0;
                })

        },
        byKey: key => {
            const promise = new Promise((resolve, reject) => {
                resolve();
            });
            console.log(key);
            return promise;
        },
        loadMode: "raw",
        cacheRawData: true
    });
}