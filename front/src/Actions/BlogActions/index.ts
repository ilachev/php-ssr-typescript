// #region Local Imports
import { ActionConsts } from "@Definitions";
import { IBlogPage, StoreModel } from "@Interfaces";
import { Dispatch } from "redux";
import { BlogService } from "@Services";
// #endregion Local Imports

export const BlogActions = {
    Map: (payload: any) => ({
        payload,
        type: ActionConsts.Blog.SetReducer,
    }),

    Reset: () => ({
        type: ActionConsts.Blog.ResetReducer,
    }),

    GetPosts: (payload: IBlogPage.Actions.IGetPostsPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await BlogService.GetPosts({
            ...payload,
        });

        dispatch({
            payload: {
                posts: result,
            },
            type: ActionConsts.Blog.SetReducer,
        });
    },

    GetCategory: (payload: IBlogPage.Actions.IGetCategoryPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await BlogService.GetCategory({
            params: payload.params,
        });

        dispatch({
            payload: {
                category: result,
            },
            type: ActionConsts.Blog.SetReducer,
        });

        return result;
    },

    GetCategoryInfo: (
        payload: IBlogPage.Actions.IGetCategoryInfoPayload
    ) => async (dispatch: Dispatch) => {
        const result = await BlogService.GetCategoryInfo({
            params: payload.params,
        });

        dispatch({
            payload: {
                ...result,
            },
            type: ActionConsts.Info.SetReducer,
        });
    },

    GetPostInfo: (payload: IBlogPage.Actions.IGetPostInfoPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await BlogService.GetPostInfo({
            params: payload.params,
        });

        dispatch({
            payload: {
                ...result,
            },
            type: ActionConsts.Info.SetReducer,
        });
    },

    LoadMorePosts: (payload: IBlogPage.Actions.IGetPostsPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await BlogService.GetPosts({
            ...payload,
        });

        dispatch({
            payload: {
                posts: result,
            },
            type: ActionConsts.Blog.LoadMorePosts,
        });
    },

    GetPost: (payload: IBlogPage.Actions.IGetPostPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await BlogService.GetPost({
            ...payload,
        });

        dispatch({
            payload: {
                post: result,
            },
            type: ActionConsts.Blog.SetReducer,
        });

        return result;
    },

    GetComments: (payload: IBlogPage.Actions.IGetCommentsPayload) => async (
        dispatch: Dispatch
    ) => {
        const result = await BlogService.GetComments({
            ...payload,
        });

        dispatch({
            payload: {
                comments: result,
            },
            type: ActionConsts.Blog.SetReducer,
        });
    },

    LoadMoreComments: (
        payload: IBlogPage.Actions.IGetCommentsPayload
    ) => async (dispatch: Dispatch) => {
        const result = await BlogService.GetComments({
            ...payload,
        });

        dispatch({
            payload: {
                comments: result,
            },
            type: ActionConsts.Blog.LoadMoreComments,
        });
    },

    GetCommentsCount: (
        payload: IBlogPage.Actions.IGetCommentsCountPayload
    ) => async (dispatch: Dispatch) => {
        const result = await BlogService.GetCommentsCount({
            ...payload,
        });

        dispatch({
            payload: {
                commentsCount: result,
            },
            type: ActionConsts.Blog.SetReducer,
        });
    },

    LeaveComment: (
        payload: IBlogPage.Actions.IPostLeaveCommentPayload
    ) => async (
        dispatch: Dispatch
    ): Promise<StoreModel.PostLeaveCommentResponse> => {
        const result = await BlogService.LeaveComment({
            ...payload,
        });

        dispatch({
            payload: {
                leaveComment: result,
            },
            type: ActionConsts.Blog.SetReducer,
        });

        return result;
    },
};
