import CustomStore from "devextreme/data/custom_store";

import {wrapHost} from "./UrlHostPath";
import {fetchUrl} from "./SourceLib";

export class SourceCodeParam {

    constructor(sType, stamp = null){
        this.sourceType = sType;
        this.timeStamp = stamp === null ? Math.round(Date.now() / 1000) : stamp;
        this.sourceCode = "";
        this.loaded = null;
    }
}

export default scParam => {
    return new CustomStore({
        load: () => {

            const url = wrapHost(`/finam/tools/${scParam.sourceType}/${scParam.timeStamp}`);

            return fetchUrl(url);

        },
        byKey: key => {

            console.log(key);

            const url = wrapHost(`/finam/tools/${scParam.sourceType}/${scParam.timeStamp}/${scParam.sourceCode}`);

            return fetchUrl(url, true);
        },
        onLoaded: result => {
            if(typeof scParam.loaded === "function") scParam.loaded();
        },
        loadMode: "raw",
        cacheRawData: true
    });
}

