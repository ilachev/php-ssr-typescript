// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

declare namespace IPromoSelector {
    export interface IProps extends WithTranslation {
        promoCount: {
            count: [
                {
                    type: string;
                    count: number;
                    name: string;
                }
            ];
        };
        slug: string;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IPromoSelector };
