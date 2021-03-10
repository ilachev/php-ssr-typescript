// #region Local Imports
import { ActionConsts } from "@Definitions";
import { IIStorePage, StoreModel } from "@Interfaces";
import { Dispatch } from "redux";
import { StoreService } from "@Services";
// #endregion Local Imports

export const StoreActions = {
    Map: (payload: any) => ({
        payload,
        type: ActionConsts.Store.SetReducer,
    }),

    Reset: () => ({
        type: ActionConsts.Store.ResetReducer,
    }),

    SelectPromoType: (payload: string) => ({
        type: ActionConsts.Store.SelectPromoType,
        payload,
    }),

    GetStore: (payload: IIStorePage.Actions.IGetStorePayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await StoreService.GetStore({
            params: payload.params,
        });

        dispatch({
            payload: {
                store: result,
            },
            type: ActionConsts.Store.SetReducer,
        });

        return result;
    },

    GetStorePageInfo: (
        payload: IIStorePage.Actions.IGetStorePageInfoPayload
    ) => async (dispatch: Dispatch) => {
        const result = await StoreService.GetStorePageInfo({
            params: payload.params,
        });

        dispatch({
            payload: {
                ...result,
            },
            type: ActionConsts.Info.SetReducer,
        });
    },

    GetPromos: (payload: IIStorePage.Actions.IGetPromosPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await StoreService.GetPromos({
            params: payload.params,
        });

        dispatch({
            payload: {
                promos: result,
            },
            type: ActionConsts.Store.SetReducer,
        });
    },

    GetOldPromos: (payload: IIStorePage.Actions.IGetPromosPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await StoreService.GetPromos({
            params: payload.params,
        });

        dispatch({
            payload: {
                old_promos: result,
            },
            type: ActionConsts.Store.SetReducer,
        });
    },

    GetPromosCount: (
        payload: IIStorePage.Actions.IGetPromosCountPayload
    ) => async (dispatch: Dispatch) => {
        const result = await StoreService.GetPromosCount({
            params: payload.params,
        });

        dispatch({
            payload: {
                promoCount: result,
            },
            type: ActionConsts.Store.SetReducer,
        });
    },

    GetComments: (payload: IIStorePage.Actions.IGetCommentsPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await StoreService.GetComments({
            ...payload,
        });

        dispatch({
            payload: {
                comments: result,
            },
            type: ActionConsts.Store.SetReducer,
        });
    },

    LoadMoreComments: (
        payload: IIStorePage.Actions.IGetCommentsPayload
    ) => async (dispatch: Dispatch) => {
        const result = await StoreService.GetComments({
            ...payload,
        });

        dispatch({
            payload: {
                comments: result,
            },
            type: ActionConsts.Store.LoadMoreComments,
        });
    },

    GetCommentsCount: (
        payload: IIStorePage.Actions.IGetCommentsCountPayload
    ) => async (dispatch: Dispatch) => {
        const result = await StoreService.GetCommentsCount({
            ...payload,
        });

        dispatch({
            payload: {
                commentsCount: result,
            },
            type: ActionConsts.Store.SetReducer,
        });
    },

    LeaveComment: (
        payload: IIStorePage.Actions.IPostLeaveCommentPayload
    ) => async (
        dispatch: Dispatch
    ): Promise<StoreModel.PostLeaveCommentResponse> => {
        const result = await StoreService.LeaveComment({
            ...payload,
        });

        dispatch({
            payload: {
                leaveComment: result,
            },
            type: ActionConsts.Store.SetReducer,
        });

        return result;
    },
};
