// #region Local Imports
import { ActionConsts } from "@Definitions";
import { merge } from "@Helpers/util";
// #endregion Local Imports

// #region Interface Imports
import { IAction, IBlogPage } from "@Interfaces";
// #endregion Interface Imports

const INITIAL_STATE: IBlogPage.IStateProps = {
    isBaseCommentFormActive: true,
    activeCommentId: "",
    posts: {
        items: [
            {
                id: "",
                description: "",
                name: "",
                slug: "",
                date: "",
                date_atom: "",
                comments: {
                    count: 0,
                    info: "",
                },
                logo: {
                    name: "",
                    url: "",
                },
                category: {
                    slug: "",
                    name: "",
                },
                author: {
                    name: "",
                    avatar: "",
                },
            },
        ],
        pagination: {
            count: 0,
            page: 0,
            pages: 0,
            per_page: 0,
            total: 0,
        },
    },
    post: {
        id: "",
        description: "",
        name: "",
        slug: "",
        date: "",
        date_atom: "",
        comments: {
            count: 0,
            info: "",
        },
        logo: {
            name: "",
            url: "",
        },
        category: {
            slug: "",
            name: "",
        },
        author: {
            name: "",
            avatar: "",
        },
    },
    category: {
        id: "",
        name: "",
        slug: "",
    },
    comments: {
        items: [
            {
                id: "",
                text: "",
                level: 0,
                parent_id: null,
                author_id: "",
                author_name: "",
                avatar: "",
                date: "",
                date_atom: "",
                user_role: null,
                children: [],
            },
        ],
        pagination: {
            count: 0,
            page: 0,
            pages: 0,
            per_page: 0,
            total: 0,
        },
    },
    commentsCount: {
        count: 0,
    },
    leaveComment: {
        data: {
            text: "",
        },
        errors: {
            violations: [],
        },
        status: "",
    },
};

type IBlogPayload = IBlogPage.Actions.IMapPayload;

export const BlogReducer = (
    state = INITIAL_STATE,
    action: IAction<IBlogPayload>
) => {
    switch (action.type) {
        case ActionConsts.Blog.SetReducer:
            return {
                ...state,
                ...action.payload,
            };

        case ActionConsts.Blog.ResetReducer:
            return INITIAL_STATE;

        case ActionConsts.Blog.LoadMorePosts:
            return {
                ...state,
                posts: merge(state.posts, action.payload?.posts),
            };

        case ActionConsts.Blog.LoadMoreComments:
            return {
                ...state,
                comments: merge(state.comments, action.payload?.comments),
            };

        default:
            return state;
    }
};
