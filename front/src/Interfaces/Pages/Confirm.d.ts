// #region Global Imports
import { WithTranslation } from "next-i18next";
import { ConfirmModel } from "@Services/API/Confirm/Confirm";
// #endregion Global Imports

declare namespace IConfirmPage {
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
                violations: Array<object>;
            };
            status: string;
        };
    }

    namespace Actions {
        export interface IMapPayload {}

        export interface IMapResponse {}

        export interface ISendConfirmPayload
            extends ConfirmModel.SendConfirmPayload {}

        export interface ISendConfirmResponse
            extends ConfirmModel.SendConfirmResponse {}
    }
}

export { IConfirmPage };
