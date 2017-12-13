import CustomStore from "devextreme/data/custom_store";

import {wrapHost} from "./UrlHostPath";
import {fetchUrl} from "./SourceLib";

export interface IFinDataSourceParam {
    sourceCode: string;
    timeStamp: number;
}

export const finDataSourceParam: IFinDataSourceParam = {
    sourceCode: "",
    timeStamp: Math.round(Date.now() / 1000)
};

export default (getParam: () => IFinDataSourceParam) => {
    return new CustomStore({
        load: () => {

            const param = getParam();

            const url: string = wrapHost(`/finam/data/${param.sourceCode}/${param.timeStamp}`);

            return fetchUrl(url);
        },
        byKey: key => {
            const promise = new Promise((resolve) => {
                resolve();
            });
            console.log(key);
            return promise;
        }
    });
}