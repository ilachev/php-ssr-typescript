// #region Local Imports
import { ActionConsts } from "@Definitions";
// #endregion Local Imports

// #region Interface Imports
import { IAction, IResetPage } from "@Interfaces";
// #endregion Interface Imports

const INITIAL_STATE: IResetPage.IStateProps = {
    confirm: {
        data: {
            token: "",
        },
        errors: {
            violations: [],
        },
        status: "",
    },
    reset: {
        data: {
            token: "",
            password: "",
        },
        errors: {
            violations: [],
        },
        status: "",
    },
};

type IResetPayload = IResetPage.Actions.IMapPayload;

export const ResetReducer = (
    state = INITIAL_STATE,
    action: IAction<IResetPayload>
) => {
    switch (action.type) {
        case ActionConsts.Reset.SetReducer:
            return {
                ...state,
                ...action.payload,
            };

        case ActionConsts.Reset.ResetReducer:
            return INITIAL_STATE;

        default:
            return state;
    }
};
