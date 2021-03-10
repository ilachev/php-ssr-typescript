// #region Local Imports
import { ActionConsts } from "@Definitions";
import { IResetPage } from "@Interfaces";
import { Dispatch } from "redux";
import { ResetService } from "@Services";
// #endregion Local Imports

export const ResetActions = {
    Map: (payload: any) => ({
        payload,
        type: ActionConsts.Reset.SetReducer,
    }),

    ResetReducer: () => ({
        type: ActionConsts.Reset.ResetReducer,
    }),

    Confirm: (payload: IResetPage.Actions.ISendResetConfirmPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await ResetService.Confirm({
            ...payload,
        });

        dispatch({
            payload: {
                confirm: result,
            },
            type: ActionConsts.Reset.SetReducer,
        });
    },

    Reset: (payload: IResetPage.Actions.ISendResetPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await ResetService.Reset({
            ...payload,
        });

        dispatch({
            payload: {
                reset: result,
            },
            type: ActionConsts.Reset.SetReducer,
        });
    },
};
