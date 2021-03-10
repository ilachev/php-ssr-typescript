// #region Local Imports
import { ActionConsts } from "@Definitions";
import { merge } from "@Helpers/util";
// #endregion Local Imports

// #region Interface Imports
import { IAction, IStorePage } from "@Interfaces";
// #endregion Interface Imports

const INITIAL_STATE: IStorePage.IStateProps = {
    activePromoType: "all",
    isPromoCodeClicked: false,
    isBaseCommentFormActive: true,
    activeCommentId: "",
    store: {
        id: "",
        description: "",
        name: "string",
        slug: "",
        logo: {
            name: "",
            url: "",
        },
        info: {
            contacts: "",
            delivery: "",
            payment: "",
            detail: "",
        },
    },
    promos: {
        items: [
            {
                id: 0,
                name: "",
                status: "",
                type: "",
                discount: 0,
                discount_unit: "percent",
                referral: "",
            },
        ],
        pagination: {
            count: 0,
            page: 0,
            pages: 0,
            per_page: 0,
            total: 0,
        },
    },
    old_promos: {
        items: [
            {
                id: 0,
                name: "",
                status: "",
                type: "",
                discount: 0,
                discount_unit: "percent",
                referral: "",
            },
        ],
        pagination: {
            count: 0,
            page: 0,
            pages: 0,
            per_page: 0,
            total: 0,
        },
    },
    promoCount: {
        count: [
            {
                type: "all",
                count: 0,
                name: "Все",
            },
        ],
    },
    comments: {
        items: [
            {
                id: "",
                text: "",
                level: 0,
                parent_id: null,
                author_id: "",
                author_name: "",
                avatar: "",
                date: "",
                date_atom: "",
                user_role: null,
                children: [],
            },
        ],
        pagination: {
            count: 0,
            page: 0,
            pages: 0,
            per_page: 0,
            total: 0,
        },
    },
    commentsCount: {
        count: 0,
    },
    leaveComment: {
        data: {
            text: "",
        },
        errors: {
            violations: [],
        },
        status: "",
    },
};

type IMapPayload = IStorePage.Actions.IMapPayload;

export const StoreReducer = (
    state = INITIAL_STATE,
    action: IAction<IMapPayload>
) => {
    switch (action.type) {
        case ActionConsts.Store.SetReducer:
            return {
                ...state,
                ...action.payload,
            };

        case ActionConsts.Store.ResetReducer:
            return INITIAL_STATE;

        case ActionConsts.Store.SelectPromoType:
            return {
                ...state,
                activePromoType: action.payload,
            };

        case ActionConsts.Store.LoadMoreComments:
            return {
                ...state,
                comments: merge(state.comments, action.payload?.comments),
            };

        default:
            return state;
    }
};
