// #region Global Imports
import { Dispatch } from "redux";
// #endregion Global Imports

// #region Local Imports
import { ActionConsts } from "@Definitions";
import { CategoryService, StoreService } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage } from "@Interfaces";
// #endregion Interface Imports

export const HomeActions = {
    Map: (payload: {}) => ({
        payload,
        type: ActionConsts.Home.SetReducer,
    }),

    Reset: () => ({
        type: ActionConsts.Home.ResetReducer,
    }),

    GetCategories: (payload: IHomePage.Actions.IGetCategoryPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await CategoryService.GetCategories({
            params: payload.params,
        });

        dispatch({
            payload: {
                categories: result,
            },
            type: ActionConsts.Home.SetReducer,
        });
    },

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
            type: ActionConsts.Home.SetReducer,
        });
    },
};
