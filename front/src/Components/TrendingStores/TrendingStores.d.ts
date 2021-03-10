// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

declare namespace ITrendingStores {
    export interface IProps extends WithTranslation {
        stores: Array;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { ITrendingStores };
