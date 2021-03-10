// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

// #region Local Imports
import { Comment, Pagination } from "@Interfaces";
// #endregion Local Imports

declare namespace IComments {
    export interface IProps extends WithTranslation {
        commentsCount: {
            count: number;
        };
        comments: {
            items: Array<Comment>;
            pagination: Pagination;
        };
        slug: string;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IComments };
