// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

declare namespace IBreadcrumbs {
    export interface IProps extends WithTranslation {
        breadcrumbsData: {
            name: string;
            ref?: string;
        }[];
        containerCss?: object;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IBreadcrumbs };
