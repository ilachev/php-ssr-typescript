// #region Global Imports
import { WithTranslation } from "next-i18next";
import { ResetModel } from "@Services/API/Reset/Reset";
import { Violation } from "@Interfaces/Violation";
// #endregion Global Imports

declare namespace IResetPage {
    export interface IProps extends WithTranslation {}

    export interface InitialProps {
        namespacesRequired: string[];
    }

    export interface IStateProps {
        confirm: {
            data: {
                token: string;
            };
            errors: {
                violations: Array<Violation>;
            };
            status: string;
        };
        reset: {
            data: {
                token: string;
                password: string;
            };
            errors: {
                violations: Array<Violation>;
            };
            status: string;
        };
    }

    namespace Actions {
        export interface IMapPayload {}

        export interface IMapResponse {}

        export interface ISendResetPayload
            extends ResetModel.SendResetPayload {}

        export interface ISendResetResponse
            extends ResetModel.SendResetResponse {}

        export interface ISendResetConfirmPayload
            extends ResetModel.SendResetConfirmPayload {}

        export interface ISendResetConfirmResponse
            extends ResetModel.SendResetConfirmResponse {}
    }
}

export { IResetPage };
