// #region Interface Imports
import { AuthInfo, HeaderPayload, HeaderResponse } from "@Interfaces";
// #endregion Interface Imports

declare namespace HeaderModel {
    export interface LogInPayload extends HeaderPayload {}

    export interface LogInResponse extends HeaderResponse {}

    export interface SignUpPayload extends HeaderPayload {}

    export interface SignUpResponse extends HeaderResponse {}

    export interface ResetPayload extends HeaderPayload {}

    export interface ResetResponse extends HeaderResponse {}

    export interface GetProfilePayload extends HeaderPayload {
        authInfo?: AuthInfo;
    }

    export interface GetProfileResponse extends HeaderResponse {}

    export interface GetSearchResultsPayload extends HeaderPayload {}

    export interface GetSearchResultsResponse extends HeaderResponse {}
}

export { HeaderModel };
