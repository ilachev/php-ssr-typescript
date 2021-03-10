// #region Local Imports
import { ActionConsts } from "@Definitions";
import { IConfirmPage } from "@Interfaces";
import { Dispatch } from "redux";
import { ConfirmService } from "@Services";
// #endregion Local Imports

export const ConfirmActions = {
    Map: (payload: any) => ({
        payload,
        type: ActionConsts.Confirm.SetReducer,
    }),

    Reset: () => ({
        type: ActionConsts.Confirm.ResetReducer,
    }),

    Confirm: (payload: IConfirmPage.Actions.ISendConfirmPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await ConfirmService.Confirm({
            ...payload,
        });

        dispatch({
            payload: {
                confirm: result,
            },
            type: ActionConsts.Confirm.SetReducer,
        });
    },
};
