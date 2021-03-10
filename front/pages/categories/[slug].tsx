// #region Global Imports
import * as React from "react";
import { NextPage } from "next";
import { useSelector } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Footer, Header, Layout, TrendingStores } from "@Components";
import { IStore } from "@Redux/IStore";
import { CategoryActions } from "@Actions";
import { Breadcrumbs } from "@Components/Breadcrumbs";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage, ReduxNextPageContext } from "@Interfaces";
import { Category } from "@Components/Category";
// #endregion Interface Imports

const CategoryPage: NextPage<IHomePage.IProps, IHomePage.InitialProps> = ({
    info,
}) => {
    const stores = useSelector((state: IStore) => state.Category.stores);
    const category = useSelector((state: IStore) => state.Category.category);

    const breadcrumbsData = [
        {
            name: "Главная",
            ref: "/",
        },
        {
            name: "Категории",
            ref: "/categories",
        },
        {
            name: category.name,
            ref: undefined,
        },
    ];

    return (
        <>
            <Header />
            <Layout padding={["32px 16px 16px", null, null, null, "30px"]}>
                <Breadcrumbs breadcrumbsData={breadcrumbsData} />
                <Category stores={stores} h1={info.seo.h1} />
            </Layout>
            <Footer />
        </>
    );
};

CategoryPage.getInitialProps = async (
    ctx: ReduxNextPageContext
): Promise<IHomePage.InitialProps> => {
    const { slug } = ctx.query;

    const res = await ctx.store.dispatch(
        CategoryActions.GetCategory({
            params: {
                slug,
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
        CategoryActions.GetCategoryPageInfo({
            params: {
                slug,
            },
        })
    );

    await ctx.store.dispatch(
        CategoryActions.GetStores({
            params: {
                "filter[category]": slug,
            },
        })
    );

    return {
        namespacesRequired: ["common"],
        info: ctx.store.getState().Info,
    };
};

export default withTranslation("common")(CategoryPage);
