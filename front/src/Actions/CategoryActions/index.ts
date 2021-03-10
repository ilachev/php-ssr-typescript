// #region Global Imports
import { Dispatch } from "redux";
// #endregion Global Imports

// #region Local Imports
import { ActionConsts } from "@Definitions";
import { StoreService, CategoryService } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage, IIStorePage, ICategoryPage } from "@Interfaces";
// #endregion Interface Imports

export const CategoryActions = {
    Map: (payload: {}) => ({
        payload,
        type: ActionConsts.Category.SetReducer,
    }),

    Reset: () => ({
        type: ActionConsts.Category.ResetReducer,
    }),

    GetStores: (payload: IHomePage.Actions.IGetStorePayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await StoreService.GetStores({
            params: payload.params,
        });

        dispatch({
            payload: {
                stores: result,
            },
            type: ActionConsts.Category.SetReducer,
        });
    },

    GetCategoryPageInfo: (
        payload: ICategoryPage.Actions.IGetCategoryPageInfoPayload
    ) => async (dispatch: Dispatch) => {
        const result = await CategoryService.GetCategoryPageInfo({
            params: payload.params,
        });

        dispatch({
            payload: {
                ...result,
            },
            type: ActionConsts.Info.SetReducer,
        });

        return result;
    },

    GetCategory: (
        payload: ICategoryPage.Actions.IGetCategoryPageInfoPayload
    ) => async (dispatch: Dispatch) => {
        const result = await CategoryService.GetCategory({
            params: payload.params,
        });

        dispatch({
            payload: {
                category: result,
            },
            type: ActionConsts.Category.SetReducer,
        });

        return result;
    },
};
