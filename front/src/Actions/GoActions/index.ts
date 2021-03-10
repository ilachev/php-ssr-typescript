// #region Local Imports
import { IGoPage } from "@Interfaces";
import { GoService } from "@Services";
// #endregion Local Imports

export const GoActions = {
    GetReferral: (payload: IGoPage.Actions.IGetReferralPayload) => async () => {
        return await GoService.GetReferral({
            ...payload,
        });
    },
};
