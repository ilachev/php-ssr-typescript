// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

declare namespace IInfo {
    export interface IProps extends WithTranslation {
        description: string;
        info: {
            contacts?: string;
            delivery?: string;
            payment?: string;
            detail?: string;
        };
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IInfo };
