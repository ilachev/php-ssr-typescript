// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

declare namespace IStoreSidebar {
    export interface IProps extends WithTranslation {
        h1: string;
        description: string;
        info: {
            contacts?: string;
            delivery?: string;
            payment?: string;
            detail?: string;
        };
        name: string;
        seoDescription: string;
        logo?: {
            url: string;
            name: string;
        };
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IStoreSidebar };
