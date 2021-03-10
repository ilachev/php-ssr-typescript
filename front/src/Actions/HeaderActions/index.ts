// #region Local Imports
import { ActionConsts } from "@Definitions";
import { IHomePage } from "@Interfaces";
import { Dispatch } from "redux";
import { HeaderService } from "@Services";
// #endregion Local Imports

export const HeaderActions = {
    Map: (payload: any) => ({
        payload,
        type: ActionConsts.Header.SetReducer,
    }),

    Reset: () => ({
        type: ActionConsts.Header.ResetReducer,
    }),

    OpenMobileMenu: () => ({
        type: ActionConsts.Header.ToggleMobileMenu,
        payload: {
            mobileMenuIsOpen: true,
        },
    }),

    CloseMobileMenu: () => ({
        type: ActionConsts.Header.ToggleMobileMenu,
        payload: {
            mobileMenuIsOpen: false,
        },
    }),

    SignUp: (payload: IHomePage.Actions.ISignUpPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await HeaderService.SignUp({
            ...payload,
        });

        dispatch({
            payload: {
                signUp: result,
            },
            type: ActionConsts.Header.SetReducer,
        });
    },

    LogIn: (payload: IHomePage.Actions.ILogInPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await HeaderService.LogIn({
            ...payload,
        });

        dispatch({
            payload: result,
            type: ActionConsts.Header.LogIn,
        });
    },

    ResetPassword: (payload: IHomePage.Actions.IResetPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await HeaderService.Reset({
            ...payload,
        });

        dispatch({
            payload: {
                reset: result,
            },
            type: ActionConsts.Header.SetReducer,
        });
    },

    GetProfile: (payload: IHomePage.Actions.IGetProfilePayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await HeaderService.GetProfile({
            ...payload,
        });

        dispatch({
            payload: {
                profile: result,
            },
            type: ActionConsts.Header.SetReducer,
        });
    },

    GetSearchResults: (
        payload: IHomePage.Actions.IGetSearchResultsPayload
    ) => async (dispatch: Dispatch) => {
        const result = await HeaderService.GetSearchResults({
            ...payload,
        });

        dispatch({
            payload: {
                search: result,
            },
            type: ActionConsts.Header.SetReducer,
        });
    },
};
