// #region Interface Imports
import { ResetPayload, ResetResponse } from "@Interfaces";
// #endregion Interface Imports

declare namespace ResetModel {
    export interface SendResetPayload extends ResetPayload {}

    export interface SendResetResponse extends ResetResponse {}

    export interface SendResetConfirmPayload extends ResetPayload {}

    export interface SendResetConfirmResponse extends ResetResponse {}
}

export { ResetModel };
