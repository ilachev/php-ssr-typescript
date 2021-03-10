// #region Local Imports
import { Http } from "@Services";
// #endregion Local Imports

// #region Interface Imports
import { BlogModel } from "@Interfaces";
// #endregion Interface Imports

export const BlogService = {
    GetPosts: async (
        payload: BlogModel.GetPostsPayload
    ): Promise<BlogModel.GetPostsResponse> => {
        let response: BlogModel.GetPostsResponse;

        try {
            response = await Http.Request<BlogModel.GetPostsResponse>(
                "GET",
                "/api/blog/posts",
                payload.params
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    GetCategory: async (
        payload: BlogModel.GetCategoryPayload
    ): Promise<BlogModel.GetCategoryResponse> => {
        let response: BlogModel.GetCategoryResponse;

        try {
            response = await Http.Request<BlogModel.GetCategoryResponse>(
                "GET",
                `/api/blog/categories/${payload.params.slug}`
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    GetCategoryInfo: async (
        payload: BlogModel.GetCategoryInfoPayload
    ): Promise<BlogModel.GetCategoryInfoResponse> => {
        let response: BlogModel.GetCategoryInfoResponse;

        try {
            response = await Http.Request<BlogModel.GetCategoryInfoResponse>(
                "GET",
                `/api/blog/categories/${payload.params.slug}/info`
            );
        } catch (error) {
            response = error;
        }

        return response;
    },

    GetPostInfo: async (
        payload: BlogModel.GetPostInfoPayload
    ): Promise<BlogModel.GetPostInfoResponse> => {
        let response: BlogModel.GetPostInfoResponse;

        try {
            response = await Http.Request<BlogModel.GetPostInfoResponse>(
                "GET",
                `/api/blog/categories/${payload.params.categorySlug}/posts/${payload.params.slug}/info`
            );
        } catch (error) {
            response = error;
        }

        return response;
    },

    GetPost: async (
        payload: BlogModel.GetPostPayload
    ): Promise<BlogModel.GetPostResponse> => {
        let response: BlogModel.GetPostResponse;

        try {
            response = await Http.Request<BlogModel.GetPostResponse>(
                "GET",
                `/api/blog/categories/${payload.params.categorySlug}/posts/${payload.params.slug}`,
                undefined,
                undefined,
                undefined,
                payload.authInfo
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },

    GetComments: async (
        payload: BlogModel.BlogGetCommentsPayload
    ): Promise<BlogModel.BlogGetCommentsResponse> => {
        let response: BlogModel.BlogGetCommentsResponse;

        try {
            response = await Http.Request<BlogModel.BlogGetCommentsResponse>(
                "GET",
                "/api/blog/posts/comments/index",
                payload.params,
                undefined,
                undefined,
                payload.authInfo
            );
        } catch (error) {
            response = error;
        }

        return response;
    },

    GetCommentsCount: async (
        payload: BlogModel.BlogGetCommentsCountPayload
    ): Promise<BlogModel.BlogGetCommentsCountResponse> => {
        let response: BlogModel.BlogGetCommentsCountResponse;

        try {
            response = await Http.Request<BlogModel.BlogGetCommentsCountResponse>(
                "GET",
                "/api/blog/posts/comments/count",
                payload.params,
                undefined,
                undefined,
                payload.authInfo
            );
        } catch (error) {
            response = { commentsCount: { count: 0 } };
        }

        return response;
    },

    LeaveComment: async (
        payload: BlogModel.BlogPostLeaveCommentPayload
    ): Promise<BlogModel.BlogPostLeaveCommentResponse> => {
        let response: BlogModel.BlogPostLeaveCommentResponse;

        try {
            response = await Http.Request<BlogModel.BlogPostLeaveCommentResponse>(
                "POST",
                "/api/blog/posts/comments/create",
                undefined,
                payload.payload,
                undefined,
                payload.authInfo
            );
        } catch (errors) {
            response = errors;
        }

        return response;
    },
};
