import CustomStore from "devextreme/data/custom_store";

import {wrapHost} from "./UrlHostPath";
import {fetchUrl} from "./SourceLib";

export class SourceCodeParam {

    constructor(sType: number){
        this.sourceType = sType;
        this.timeStamp = Math.round(Date.now() / 1000);
    }

    sourceType: number;

    timeStamp: number;

    sourceCode: string;
}

export default (scParam: SourceCodeParam) : CustomStore => {
    return new CustomStore({
        load: () => {

            const url: string = wrapHost(`/finam/tools/${scParam.sourceType}/${scParam.timeStamp}`);

            return fetchUrl(url);

        },
        byKey: key => {

            console.log(key);

            const url: string = wrapHost(`/finam/tools/${scParam.sourceType}/${scParam.timeStamp}/${scParam.sourceCode}`);

            return fetchUrl(url, true);
        },
        loadMode: "raw",
        cacheRawData: true
    });
}

