// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

declare namespace IPromoCodeButton {
    export interface IProps extends WithTranslation {
        code?: string;
        referral: string;
        modalIsOpen: boolean;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IPromoCodeButton };
