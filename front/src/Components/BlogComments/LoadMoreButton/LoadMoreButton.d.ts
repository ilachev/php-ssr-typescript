// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

// #region Local Imports
import { Pagination } from "@Interfaces";
// #endregion Local Imports

declare namespace ILoadMoreButton {
    export interface IProps extends WithTranslation {
        pagination: Pagination;
        slug: string;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { ILoadMoreButton };
