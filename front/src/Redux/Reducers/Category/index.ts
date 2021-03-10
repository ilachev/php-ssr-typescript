// #region Local Imports
import { ActionConsts } from "@Definitions";
// #endregion Local Imports

// #region Interface Imports
import { IAction, ICategoryPage } from "@Interfaces";
// #endregion Interface Imports

const INITIAL_STATE: ICategoryPage.IStateProps = {
    category: {
        id: "",
        name: "",
        slug: "",
    },
    stores: [
        {
            id: "",
            name: "",
        },
    ],
};

type IMapPayload = ICategoryPage.Actions.IMapPayload;

export const CategoryReducer = (
    state = INITIAL_STATE,
    action: IAction<IMapPayload>
) => {
    switch (action.type) {
        case ActionConsts.Category.SetReducer:
            return {
                ...state,
                ...action.payload,
            };

        case ActionConsts.Category.ResetReducer:
            return INITIAL_STATE;

        default:
            return state;
    }
};
