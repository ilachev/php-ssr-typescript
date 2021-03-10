// #region Interface Imports
import { CategoriesPayload, CategoriesResponse } from "@Interfaces";
// #endregion Interface Imports

declare namespace CategoryModel {
    export interface GetCategoryPayload {
        params: CategoriesPayload;
    }

    export interface GetCategoryResponse extends CategoriesResponse {
        status?: number;
    }

    export interface GetCategoriesPayload {
        params: CategoriesPayload;
    }

    export interface GetCategoriesResponse extends CategoriesResponse {}

    export interface GetStoresPayload {
        params: CategoriesPayload;
    }

    export interface GetStoresResponse extends CategoriesResponse {}

    export interface GetCategoryPageInfoPayload {
        params: CategoriesPayload;
    }

    export interface GetCategoryPageInfoResponse extends CategoriesResponse {
        status?: number;
    }
}

export { CategoryModel };
