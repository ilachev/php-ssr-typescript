// #region Global Imports
import { WithTranslation } from "next-i18next";
import { CategoryModel } from "@Services/API/Category/Category";
import { StoreModel } from "@Services/API/Store/Store";
import { HeaderModel } from "@Services/API/Header/Header";
import { AuthInfo } from "@Interfaces/AuthInfo";
// #endregion Global Imports

declare namespace IHomePage {
    export interface IProps extends WithTranslation {
        info: {
            seo: {
                h1: string;
            };
        };
    }

    export interface InitialProps {
        namespacesRequired: string[];
        info: object;
        statusCode?: number;
    }

    export interface IStateProps {
        home: {
            version: number;
        };
        categories: [
            {
                id: string;
                name: string;
            }
        ];
        stores: [
            {
                id: string;
                name: string;
            }
        ];
    }

    namespace Actions {
        export interface IMapPayload {}

        export interface IMapResponse {}

        export interface IGetCategoryPayload
            extends CategoryModel.GetCategoriesPayload {
            params: {};
        }

        export interface IGetCategoryResponse
            extends CategoryModel.GetCategoriesPayload {}

        export interface IGetStorePayload extends StoreModel.GetStoresPayload {
            params: {};
        }

        export interface IGetStoreResponse
            extends StoreModel.GetStoresResponse {}

        export interface ILogInPayload extends HeaderModel.LogInPayload {}

        export interface ILogInResponse extends HeaderModel.LogInResponse {}

        export interface ISignUpPayload extends HeaderModel.SignUpPayload {}

        export interface ISignUpResponse extends HeaderModel.SignUpResponse {}

        export interface IResetPayload extends HeaderModel.ResetPayload {}

        export interface IResetResponse extends HeaderModel.ResetResponse {}

        export interface IGetProfilePayload
            extends HeaderModel.GetProfilePayload {
            authInfo?: AuthInfo;
        }

        export interface IGetProfileResponse
            extends HeaderModel.GetProfileResponse {}

        export interface IGetSearchResultsPayload
            extends HeaderModel.GetSearchResultsPayload {}

        export interface IGetSearchResultsResponse
            extends HeaderModel.GetSearchResultsResponse {}
    }
}

export { IHomePage };
