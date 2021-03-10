// #region Interface Imports
import { GoPayload, GoResponse } from "@Interfaces";
// #endregion Interface Imports

declare namespace GoModel {
    export interface GetReferralPayload extends GoPayload {}

    export interface GetReferralResponse extends GoResponse {}
}

export { GoModel };
