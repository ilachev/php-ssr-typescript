// #region Interface Imports
import {
    StoresPayload,
    StoresResponse,
    StorePayload,
    StoreResponse,
    StorePageInfoPayload,
    StorePageInfoResponse,
    PromosPayload,
    PromosResponse,
    PromosCountPayload,
    PromosCountResponse,
    CommentsPayload,
    CommentsResponse,
    CommentsCountPayload,
    CommentsCountResponse,
    Comment,
    Pagination,
    AuthInfo,
    LeaveCommentPayload,
    LeaveCommentResponse,
} from "@Interfaces";
// #endregion Interface Imports

declare namespace StoreModel {
    export interface GetStoresPayload {
        params: StoresPayload;
    }

    export interface GetStoresResponse extends StoresResponse {}

    export interface GetPromosPayload {
        params: PromosPayload;
    }

    export interface GetPromosResponse extends PromosResponse {}

    export interface GetPromosCountPayload {
        params: PromosCountPayload;
    }

    export interface GetPromosCountResponse extends PromosCountResponse {}

    export interface GetCommentsPayload {
        params: CommentsPayload;
        authInfo?: AuthInfo;
    }

    export interface GetCommentsResponse extends CommentsResponse {
        items: Array<Comment>;
        pagination: Pagination;
    }

    export interface GetCommentsCountPayload {
        params: CommentsCountPayload;
        authInfo?: AuthInfo;
    }

    export interface GetCommentsCountResponse extends CommentsCountResponse {}

    export interface PostLeaveCommentPayload {
        payload: LeaveCommentPayload;
        authInfo?: AuthInfo;
    }

    export interface PostLeaveCommentResponse extends LeaveCommentResponse {}

    export interface GetStorePayload {
        params: StorePayload;
    }

    export interface GetStoreResponse extends StoreResponse {
        status?: number;
    }

    export interface GetStorePageInfoPayload {
        params: StorePageInfoPayload;
    }

    export interface GetStorePageInfoResponse extends StorePageInfoResponse {}
}

export { StoreModel };
