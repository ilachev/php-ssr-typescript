// #region Global Imports
import { WithTranslation } from "next-i18next";
import { CategoryModel } from "@Services/API/Category/Category";
// #endregion Global Imports

declare namespace ICategoryPage {
    export interface IProps extends WithTranslation {}

    export interface InitialProps {
        namespacesRequired: string[];
    }

    export interface IStateProps {
        category: {
            id: string;
            name: string;
            slug: string;
        };
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

        export interface IGetStoresPayload
            extends CategoryModel.GetStoresPayload {
            params: {};
        }

        export interface IGetStoresResponse
            extends CategoryModel.GetStoresResponse {}

        export interface IGetCategoryPageInfoPayload
            extends CategoryModel.GetCategoryPageInfoPayload {
            params: {};
        }

        export interface IGetCategoryPageInfoResponse
            extends CategoryModel.GetCategoryPageInfoResponse {}
    }
}

export { ICategoryPage };
