// #region Local Imports
import { Http } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { StoreModel } from "@Interfaces";
// #endregion Interface Imports

export const StoreService = {
    GetStores: async (
        payload: StoreModel.GetStoresPayload
    ): Promise<StoreModel.GetStoresResponse> => {
        let response: StoreModel.GetStoresResponse;

        try {
            response = await Http.Request<StoreModel.GetStoresResponse>(
                "GET",
                "/api/market/stores",
                payload.params
            );
        } catch (error) {
            response = [{ id: "", name: "" }];
        }

        return response;
    },

    GetStore: async (
        payload: StoreModel.GetStorePayload
    ): Promise<StoreModel.GetStoreResponse> => {
        let response: StoreModel.GetStoreResponse;

        try {
            response = await Http.Request<StoreModel.GetStoreResponse>(
                "GET",
                `/api/market/stores/${payload.params.slug}`
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    GetStorePageInfo: async (
        payload: StoreModel.GetStorePageInfoPayload
    ): Promise<StoreModel.GetStorePageInfoResponse> => {
        let response: StoreModel.GetStorePageInfoResponse;

        try {
            response = await Http.Request<StoreModel.GetStorePageInfoResponse>(
                "GET",
                `/api/market/stores/${payload.params.slug}/info`
            );
        } catch (error) {
            response = { seo: {} };
        }

        return response;
    },

    GetPromos: async (
        payload: StoreModel.GetPromosPayload
    ): Promise<StoreModel.GetPromosResponse> => {
        let response: StoreModel.GetPromosResponse;

        try {
            response = await Http.Request<StoreModel.GetPromosResponse>(
                "GET",
                "/api/market/promos",
                payload.params
            );
        } catch (error) {
            response = [{ id: "", name: "" }];
        }

        return response;
    },

    GetPromosCount: async (
        payload: StoreModel.GetPromosCountPayload
    ): Promise<StoreModel.GetPromosCountResponse> => {
        let response: StoreModel.GetPromosCountResponse;

        try {
            response = await Http.Request<StoreModel.GetPromosCountResponse>(
                "GET",
                "/api/market/promos/count",
                payload.params
            );
        } catch (error) {
            response = { promoCount: [{ type: "", count: 0, name: "" }] };
        }

        return response;
    },

    GetComments: async (
        payload: StoreModel.GetCommentsPayload
    ): Promise<StoreModel.GetCommentsResponse> => {
        let response: StoreModel.GetCommentsResponse;

        try {
            response = await Http.Request<StoreModel.GetCommentsResponse>(
                "GET",
                "/api/market/stores/comments/index",
                payload.params,
                undefined,
                undefined,
                payload.authInfo
            );
        } catch (error) {
            response = error;
        }

        return response;
    },

    GetCommentsCount: async (
        payload: StoreModel.GetCommentsCountPayload
    ): Promise<StoreModel.GetCommentsCountResponse> => {
        let response: StoreModel.GetCommentsCountResponse;

        try {
            response = await Http.Request<StoreModel.GetCommentsCountResponse>(
                "GET",
                "/api/market/stores/comments/count",
                payload.params,
                undefined,
                undefined,
                payload.authInfo
            );
        } catch (error) {
            response = { commentsCount: { count: 0 } };
        }

        return response;
    },

    LeaveComment: async (
        payload: StoreModel.PostLeaveCommentPayload
    ): Promise<StoreModel.PostLeaveCommentResponse> => {
        let response: StoreModel.PostLeaveCommentResponse;

        try {
            response = await Http.Request<StoreModel.PostLeaveCommentResponse>(
                "POST",
                "/api/market/stores/comments/create",
                undefined,
                payload.payload,
                undefined,
                payload.authInfo
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },
};
