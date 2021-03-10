// #region Global Imports
import * as React from "react";
import { NextPage } from "next";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Footer, Header, Layout } from "@Components";
import { Breadcrumbs } from "@Components/Breadcrumbs";
// #endregion Local Imports

// #region Interface Imports
import { IBlogPage, IStore, ReduxNextPageContext } from "@Interfaces";
import { BlogActions } from "@Actions";
import { BlogCategories } from "@Components/BlogCategories";
import { useSelector } from "react-redux";
// #endregion Interface Imports

const BlogCategoriesPage: NextPage<
    IBlogPage.IProps,
    IBlogPage.InitialProps
> = () => {
    const posts = useSelector((state: IStore) => state.Blog.posts);
    const category = useSelector((state: IStore) => state.Blog.category);
    const h1 = useSelector((state: IStore) => state.Info.seo.h1);

    const breadcrumbsData = [
        {
            name: "Главная",
            ref: "/",
        },
        {
            name: category.name,
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
                <Breadcrumbs breadcrumbsData={breadcrumbsData} />

                <BlogCategories h1={h1} posts={posts} category={category} />
            </Layout>

            <Footer />
        </>
    );
};

BlogCategoriesPage.getInitialProps = async (
    ctx: ReduxNextPageContext
): Promise<IBlogPage.InitialProps> => {
    const { categorySlug, page } = ctx.query;

    if (typeof categorySlug !== "string") {
        return {
            namespacesRequired: ["common"],
            info: {},
        };
    }

    const res = await ctx.store.dispatch(
        BlogActions.GetCategory({
            params: {
                slug: categorySlug,
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
        BlogActions.GetCategoryInfo({
            params: {
                slug: categorySlug,
            },
        })
    );

    await ctx.store.dispatch(
        BlogActions.GetPosts({
            params: {
                "filter[category]": categorySlug,
                "filter[status]": "active",
                per_page: "15",
                page: undefined !== page ? page.toString() : "1",
                sort: "date",
                direction: "desc",
            },
        })
    );

    return {
        namespacesRequired: ["common"],
        info: ctx.store.getState().Info,
    };
};

export default withTranslation("common")(BlogCategoriesPage);
