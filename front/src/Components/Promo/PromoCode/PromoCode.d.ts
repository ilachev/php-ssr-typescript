// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

declare namespace IPromoCode {
    export interface IProps extends WithTranslation {
        promo: {
            id: number;
            name: string;
            status: string;
            type: string;
            discount?: number;
            discount_unit?: string;
            description?: string;
            start_date?: string;
            end_date?: string;
            is_expired?: boolean;
            code?: string;
            referral: string;
        };
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IPromoCode };
