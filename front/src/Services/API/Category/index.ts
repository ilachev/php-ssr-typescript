// #region Local Imports
import { Http } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { CategoryModel } from "@Interfaces";
// #endregion Interface Imports

export const CategoryService = {
    GetCategory: async (
        payload: CategoryModel.GetCategoryPayload
    ): Promise<CategoryModel.GetCategoryResponse> => {
        let response: CategoryModel.GetCategoryResponse;

        try {
            response = await Http.Request<CategoryModel.GetCategoryResponse>(
                "GET",
                `/api/market/categories/${payload.params.slug}`
            );
        } catch (error) {
            response = error;
        }

        return response;
    },

    GetCategories: async (
        payload: CategoryModel.GetCategoriesPayload
    ): Promise<CategoryModel.GetCategoriesResponse> => {
        let response: CategoryModel.GetCategoriesResponse;

        try {
            response = await Http.Request<CategoryModel.GetCategoriesResponse>(
                "GET",
                "/api/market/categories",
                payload.params
            );
        } catch (error) {
            response = [{ id: "", name: "" }];
        }

        return response;
    },

    GetCategoryPageInfo: async (
        payload: CategoryModel.GetCategoryPageInfoPayload
    ): Promise<CategoryModel.GetCategoryPageInfoResponse> => {
        let response: CategoryModel.GetCategoryPageInfoResponse;

        try {
            response = await Http.Request<CategoryModel.GetCategoryPageInfoResponse>(
                "GET",
                `/api/market/categories/${payload.params.slug}/info`
            );
        } catch (error) {
            response = error;
        }

        return response;
    },
};
