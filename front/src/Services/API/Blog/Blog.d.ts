// #region Interface Imports
import {
    AuthInfo,
    BlogPayload,
    BlogResponse,
    Comment,
    BlogCommentsCountPayload,
    BlogCommentsCountResponse,
    BlogCommentsPayload,
    BlogCommentsResponse,
    BlogLeaveCommentPayload,
    BlogLeaveCommentResponse,
    Pagination,
} from "@Interfaces";
// #endregion Interface Imports

declare namespace BlogModel {
    export interface GetPostsPayload {
        params: BlogPayload;
    }

    export interface GetPostsResponse extends BlogResponse {}

    export interface GetCategoryPayload {
        params: BlogPayload;
    }

    export interface GetCategoryResponse extends BlogResponse {
        status?: number;
    }

    export interface GetCategoryInfoPayload {
        params: BlogPayload;
    }

    export interface GetCategoryInfoResponse extends BlogResponse {}

    export interface GetPostInfoPayload {
        params: BlogPayload;
    }

    export interface GetPostInfoResponse extends BlogResponse {}

    export interface GetPostPayload {
        params: BlogPayload;
        authInfo?: AuthInfo;
    }

    export interface GetPostResponse extends BlogResponse {
        status?: number;
    }

    export interface BlogGetCommentsPayload {
        params: BlogCommentsPayload;
        authInfo?: AuthInfo;
    }

    export interface BlogGetCommentsResponse extends BlogCommentsResponse {
        items: Array<Comment>;
        pagination: Pagination;
    }

    export interface BlogGetCommentsCountPayload {
        params: BlogCommentsCountPayload;
        authInfo?: AuthInfo;
    }

    export interface BlogGetCommentsCountResponse
        extends BlogCommentsCountResponse {}

    export interface BlogPostLeaveCommentPayload {
        payload: BlogLeaveCommentPayload;
        authInfo?: AuthInfo;
    }

    export interface BlogPostLeaveCommentResponse
        extends BlogLeaveCommentResponse {}
}

export { BlogModel };
