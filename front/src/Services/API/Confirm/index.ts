// #region Local Imports
import { Http } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { ConfirmModel } from "@Interfaces";
// #endregion Interface Imports

export const ConfirmService = {
    Confirm: async (
        payload: ConfirmModel.SendConfirmPayload
    ): Promise<ConfirmModel.SendConfirmResponse> => {
        let response: ConfirmModel.SendConfirmResponse;

        try {
            response = await Http.Request<ConfirmModel.SendConfirmResponse>(
                "POST",
                "/api/auth/confirm",
                undefined,
                payload
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },
};
