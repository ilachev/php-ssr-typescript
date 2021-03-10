// #region Local Imports
import { ActionConsts } from "@Definitions";
// #endregion Local Imports

// #region Interface Imports
import { IAction, IHeader } from "@Interfaces";
// #endregion Interface Imports

const INITIAL_STATE: IHeader.IStateProps = {
    mobileMenuIsOpen: false,
    registrationModalIsOpen: false,
    authModalIsOpen: false,
    recoveryModalIsOpen: false,
    height: 64,
    auth: {
        access_token: "",
        expires_in: 0,
        refresh_token: "",
        token_type: "",
    },
    logIn: {
        data: {
            username: "",
            password: "",
        },
        errors: {
            error: "",
        },
        status: "",
    },
    signUp: {
        data: {
            first_name: "",
            last_name: "",
            email: "",
            password: "",
        },
        errors: {
            violations: [],
        },
        status: "",
    },
    reset: {
        data: {
            email: "",
        },
        errors: {
            violations: [],
        },
        status: "",
    },
    profile: {
        id: "",
        email: "",
        avatar: {
            url: "",
        },
        name: "",
    },
    search: {
        stores: [] as any,
        posts: [] as any,
    },
    query: "",
    resultsIsOpen: false,
};

type IMapPayload = IHeader.Actions.IMapPayload;

export const HeaderReducer = (
    state = INITIAL_STATE,
    action: IAction<IMapPayload>
) => {
    switch (action.type) {
        case ActionConsts.Header.SetReducer:
            return {
                ...state,
                ...action.payload,
            };

        case ActionConsts.Header.ResetReducer:
            return INITIAL_STATE;

        case ActionConsts.Header.ToggleMobileMenu:
            return {
                ...state,
                ...action.payload,
            };

        case ActionConsts.Header.LogIn:
            if (undefined !== action.payload) {
                if (undefined !== action.payload.error) {
                    return {
                        ...state,
                        logIn: {
                            ...state.logIn,
                            errors: { ...action.payload },
                        },
                    };
                }
                if (undefined !== action.payload.access_token) {
                    return {
                        ...state,
                        logIn: {
                            ...state.logIn,
                            data: {
                                username: "",
                                password: "",
                            },
                            errors: {
                                error: "",
                            },
                        },
                        auth: {
                            ...state.auth,
                            ...action.payload,
                        },
                    };
                }
            }

            return {
                ...state,
            };

        default:
            return state;
    }
};
