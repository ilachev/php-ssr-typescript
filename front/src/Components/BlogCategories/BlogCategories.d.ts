// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

// #region Local Imports
import { Pagination, Post } from "@Interfaces";
// #endregion Local Imports

declare namespace IBlogCategories {
    export interface IProps extends WithTranslation {
        posts: {
            items: Array<Post>;
            pagination: Pagination;
        };
        h1: string;
        category: {
            slug: string;
        };
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IBlogCategories };
