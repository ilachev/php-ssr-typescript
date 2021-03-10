// #region Local Imports
import { Http } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { ResetModel } from "@Interfaces";
// #endregion Interface Imports

export const ResetService = {
    Confirm: async (
        payload: ResetModel.SendResetConfirmPayload
    ): Promise<ResetModel.SendResetConfirmResponse> => {
        let response: ResetModel.SendResetConfirmResponse;

        try {
            response = await Http.Request<ResetModel.SendResetConfirmResponse>(
                "POST",
                "/api/auth/reset/confirm",
                undefined,
                payload
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    Reset: async (
        payload: ResetModel.SendResetPayload
    ): Promise<ResetModel.SendResetResponse> => {
        let response: ResetModel.SendResetResponse;

        try {
            response = await Http.Request<ResetModel.SendResetResponse>(
                "POST",
                "/api/auth/reset",
                undefined,
                payload
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },
};
