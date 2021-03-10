// #region Local Imports
import { Http } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { HeaderModel } from "@Interfaces";
// #endregion Interface Imports

export const HeaderService = {
    LogIn: async (
        payload: HeaderModel.LogInPayload
    ): Promise<HeaderModel.LogInResponse> => {
        let response: HeaderModel.LogInResponse;

        try {
            response = await Http.Request<HeaderModel.LogInResponse>(
                "POST",
                "/token",
                undefined,
                payload,
                "application/x-www-form-urlencoded"
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    SignUp: async (
        payload: HeaderModel.SignUpPayload
    ): Promise<HeaderModel.SignUpResponse> => {
        let response: HeaderModel.SignUpResponse;

        try {
            response = await Http.Request<HeaderModel.SignUpResponse>(
                "POST",
                "/api/auth/signup",
                undefined,
                payload
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    Reset: async (
        payload: HeaderModel.ResetPayload
    ): Promise<HeaderModel.ResetResponse> => {
        let response: HeaderModel.ResetResponse;

        try {
            response = await Http.Request<HeaderModel.ResetResponse>(
                "POST",
                "/api/auth/reset/request",
                undefined,
                payload
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    GetProfile: async (
        payload: HeaderModel.GetProfilePayload
    ): Promise<HeaderModel.GetProfileResponse> => {
        let response: HeaderModel.GetProfileResponse;

        try {
            response = await Http.Request<HeaderModel.GetProfileResponse>(
                "GET",
                "/api/profile",
                undefined,
                undefined,
                undefined,
                payload.authInfo
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    GetSearchResults: async (
        payload: HeaderModel.GetSearchResultsPayload
    ): Promise<HeaderModel.GetSearchResultsResponse> => {
        let response: HeaderModel.GetSearchResultsResponse;

        try {
            response = await Http.Request<HeaderModel.GetSearchResultsResponse>(
                "GET",
                "/api/search",
                payload
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },
};
