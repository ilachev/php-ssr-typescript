// #region Local Imports
import { ActionConsts } from "@Definitions";
// #endregion Local Imports

// #region Interface Imports
import { IAction } from "@Interfaces";
// #endregion Interface Imports

export interface IStateProps {
    seo: {
        h1: string;
        description: string;
        meta: {
            title: string;
            description: string;
            og_title: string;
            og_description: string;
        };
    };
}

const INITIAL_STATE: IStateProps = {
    seo: {
        h1: "",
        description: "",
        meta: {
            title: "",
            description: "",
            og_title: "",
            og_description: "",
        },
    },
};

type IMapPayload = {};

export const InfoReducer = (
    state = INITIAL_STATE,
    action: IAction<IMapPayload>
) => {
    switch (action.type) {
        case ActionConsts.Info.SetReducer:
            return {
                ...state,
                ...action.payload,
            };

        case ActionConsts.Info.ResetReducer:
            return INITIAL_STATE;

        default:
            return state;
    }
};
