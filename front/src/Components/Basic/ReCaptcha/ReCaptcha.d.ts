// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

declare global {
    interface Window {
        grecaptcha: any;
        captchaOnLoad: any;
    }
}

declare namespace IReCaptcha {
    export interface IProps extends WithTranslation {
        action: string;
        invisible?: boolean;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IReCaptcha };
