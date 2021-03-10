// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

// #region Local Imports
import { BlogModel } from "@Services/API/Blog/Blog";
import {
    Post,
    Pagination,
    Comment,
    Violation,
    StoreModel,
    AuthInfo,
} from "@Interfaces";
// #endregion Local Imports

declare namespace IBlogPage {
    export interface IProps extends WithTranslation {}

    export interface InitialProps {
        namespacesRequired: string[];
        info: object;
        error?: boolean;
        statusCode?: number;
    }

    export interface IStateProps {
        isBaseCommentFormActive: boolean;
        activeCommentId: string;
        posts: {
            items: Array<Post>;
            pagination: Pagination;
        };
        post: Post;
        category: {
            id: string;
            name: string;
            slug: string;
        };
        comments: {
            items: Array<Comment>;
            pagination: Pagination;
        };
        commentsCount: {
            count: number;
        };
        leaveComment: {
            data: {
                text: string;
            };
            errors: {
                violations: Array<Violation>;
            };
            status?: string;
        };
    }

    namespace Actions {
        export interface IMapPayload {
            posts: {
                items: Array<Post>;
                pagination: Pagination;
            };
            comments: {
                items: Array<Comment>;
                pagination: Pagination;
            };
        }

        export interface IMapResponse {}

        export interface IGetPostsPayload extends BlogModel.GetPostsPayload {}

        export interface IGetPostsResponse extends BlogModel.GetPostsResponse {}

        export interface IGetPostPayload extends BlogModel.GetPostPayload {}

        export interface IGetPostResponse extends BlogModel.GetPostResponse {}

        export interface IGetCategoryPayload
            extends BlogModel.GetCategoryPayload {}

        export interface IGetCategoryResponse
            extends BlogModel.GetCategoryResponse {}

        export interface IGetCategoryInfoPayload
            extends BlogModel.GetCategoryInfoPayload {}

        export interface IGetCategoryInfoResponse
            extends BlogModel.GetCategoryInfoResponse {}

        export interface IGetPostInfoPayload
            extends BlogModel.GetPostInfoPayload {}

        export interface IGetPostInfoResponse
            extends BlogModel.GetPostInfoResponse {}

        export interface IGetCommentsPayload
            extends BlogModel.BlogGetCommentsPayload {
            params: {};
            authInfo?: AuthInfo;
        }

        export interface IGetCommentsResponse
            extends BlogModel.BlogGetCommentsResponse {}

        export interface IGetCommentsCountPayload
            extends BlogModel.BlogGetCommentsCountPayload {
            params: {};
            authInfo?: AuthInfo;
        }

        export interface IGetCommentsCountResponse
            extends BlogModel.BlogGetCommentsCountResponse {}

        export interface IPostLeaveCommentPayload
            extends BlogModel.BlogPostLeaveCommentPayload {}

        export interface IPostLeaveCommentResponse
            extends StoreModel.PostLeaveCommentResponse {}
    }
}

export { IBlogPage };
