// #region Local Imports
import { ActionConsts } from "@Definitions";
// #endregion Local Imports

// #region Interface Imports
import { IAction, IConfirmPage } from "@Interfaces";
// #endregion Interface Imports

const INITIAL_STATE: IConfirmPage.IStateProps = {
    confirm: {
        data: {
            token: "",
        },
        errors: {
            violations: [],
        },
        status: "",
    },
};

type IConfirmPayload = IConfirmPage.Actions.IMapPayload;

export const ConfirmReducer = (
    state = INITIAL_STATE,
    action: IAction<IConfirmPayload>
) => {
    switch (action.type) {
        case ActionConsts.Confirm.SetReducer:
            return {
                ...state,
                ...action.payload,
            };

        case ActionConsts.Confirm.ResetReducer:
            return INITIAL_STATE;

        default:
            return state;
    }
};
