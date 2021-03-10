// #region Global Imports
import * as React from "react";
import { NextPage } from "next";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Footer, Header, Layout, Store as StoreMain } from "@Components";
import { Breadcrumbs } from "@Components/Breadcrumbs";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage, IStore, ReduxNextPageContext } from "@Interfaces";
import { BlogActions, StoreActions } from "@Actions";
import { useDispatch, useSelector } from "react-redux";
import { useEffect, useState } from "react";
import useAuth from "@Helpers/useAuth";
import { BlogPost } from "@Components/BlogPost";
// #endregion Interface Imports

const PostPage: NextPage<IHomePage.IProps, IHomePage.InitialProps> = () => {
    const post = useSelector((state: IStore) => state.Blog.post);
    const [isAuth, setIsAuth] = useState(false);
    const dispatch = useDispatch();
    const [authInfo] = useAuth();

    useEffect(() => {
        if (isAuth) {
            dispatch(
                BlogActions.GetComments({
                    params: {
                        "filter[slug]": post.slug,
                        per_page: 20,
                        page: 1,
                        sort: "date",
                        direction: "desc",
                    },
                    authInfo: authInfo!,
                })
            );
            dispatch(
                BlogActions.GetCommentsCount({
                    params: {
                        "filter[slug]": post.slug,
                    },
                    authInfo: authInfo!,
                })
            );
            dispatch(
                BlogActions.GetPost({
                    params: {
                        slug: post.slug,
                        categorySlug: post.category.slug,
                    },
                    authInfo: authInfo!,
                })
            );
        }
    }, [isAuth, dispatch, post.slug, post.category.slug]);

    useEffect(() => {
        if (authInfo) {
            setIsAuth(true);
        }

        return () => setIsAuth(false);
    }, [authInfo]);

    const breadcrumbsData = [
        {
            name: "Главная",
            ref: "/",
        },
        {
            name: `${post.category.name}`,
            ref: `/blog/${post.category.slug}`,
        },
        {
            name: `${post.name}`,
            ref: undefined,
        },
    ];

    return (
        <>
            <Header />

            <Layout
                marginBottom={2}
                padding={["32px 16px 16px", null, null, null, "30px"]}
            >
                <Breadcrumbs
                    containerCss={{
                        textAlign: "center",
                    }}
                    breadcrumbsData={breadcrumbsData}
                />

                <BlogPost post={post} />
            </Layout>

            <Footer />
        </>
    );
};

PostPage.getInitialProps = async (
    ctx: ReduxNextPageContext
): Promise<IHomePage.InitialProps> => {
    const { slug, blogCategorySlug } = ctx.query;

    // await ctx.store.dispatch(BlogActions.Reset());

    if (typeof slug !== "string" || typeof blogCategorySlug !== "string") {
        return {
            namespacesRequired: ["common"],
            info: {},
        };
    }

    const res = await ctx.store.dispatch(
        BlogActions.GetPost({
            params: {
                slug,
                categorySlug: blogCategorySlug,
            },
        })
    );

    if (res.status === 404) {
        return {
            namespacesRequired: ["common"],
            info: {
                seo: {
                    description: "",
                    h1: "",
                    meta: {
                        title: "Купонопад – страница не найдена.",
                        description: "Страница не найдена на Купонопад.",
                        og_title: "Купонопад – страница не найдена.",
                        og_description: "Страница не найдена на Купонопад.",
                    },
                },
            },
            statusCode: res.status,
        };
    }

    await ctx.store.dispatch(
        BlogActions.GetPostInfo({
            params: {
                slug,
                categorySlug: blogCategorySlug,
            },
        })
    );

    await ctx.store.dispatch(
        BlogActions.GetComments({
            params: {
                "filter[slug]": slug,
                per_page: 20,
                page: 1,
                sort: "date",
                direction: "desc",
            },
        })
    );
    await ctx.store.dispatch(
        BlogActions.GetCommentsCount({
            params: {
                "filter[slug]": slug,
            },
        })
    );

    return {
        namespacesRequired: ["common"],
        info: ctx.store.getState().Info,
    };
};

export default withTranslation("common")(PostPage);
