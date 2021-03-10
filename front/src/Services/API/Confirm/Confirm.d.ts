// #region Interface Imports
import { ConfirmPayload, ConfirmResponse } from "@Interfaces";
// #endregion Interface Imports

declare namespace ConfirmModel {
    export interface SendConfirmPayload extends ConfirmPayload {}

    export interface SendConfirmResponse extends ConfirmResponse {}
}

export { ConfirmModel };
