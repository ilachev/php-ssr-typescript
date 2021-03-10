// #region Local Imports
import { Http } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { GoModel } from "@Interfaces";
// #endregion Interface Imports

export const GoService = {
    GetReferral: async (
        payload: GoModel.GetReferralPayload
    ): Promise<GoModel.GetReferralResponse> => {
        let response: GoModel.GetReferralResponse;

        try {
            response = await Http.Request<GoModel.GetReferralResponse>(
                "GET",
                "/api/market/promos/referral",
                payload
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },
};
