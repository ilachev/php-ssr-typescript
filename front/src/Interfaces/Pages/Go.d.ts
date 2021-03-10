// #region Global Imports
import { WithTranslation } from "next-i18next";
import { GoModel } from "@Services/API/Go/Go";
// #endregion Global Imports

declare namespace IGoPage {
    export interface IProps extends WithTranslation {}

    export interface InitialProps {
        namespacesRequired: ["common"];
        info: object;
        link?: string;
    }

    export interface IStateProps {}

    namespace Actions {
        export interface IMapPayload {}

        export interface IMapResponse {}

        export interface IGetReferralPayload
            extends GoModel.GetReferralPayload {}

        export interface IGetReferralResponse
            extends GoModel.GetReferralResponse {}
    }
}

export { IGoPage };
