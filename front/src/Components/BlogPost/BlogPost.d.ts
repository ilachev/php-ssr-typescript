// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

// #region Local Imports
import { Comment, Pagination, Post } from "@Interfaces";
// #endregion Local Imports

declare namespace IBlogPost {
    export interface IProps extends WithTranslation {
        post: Post;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {
            comments: {
                items: Array<Comment>;
                pagination: Pagination;
            };
        }
        export interface IMapResponse {}
    }
}

export { IBlogPost };
