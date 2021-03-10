// #region Global Imports
import * as React from "react";
import { NextPage } from "next";
import { useSelector } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Footer, Header, Layout, TrendingCategories } from "@Components";
import { IStore } from "@Redux/IStore";
import { HomeActions } from "@Actions";
import { Breadcrumbs } from "@Components/Breadcrumbs";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage, ReduxNextPageContext } from "@Interfaces";
// #endregion Interface Imports

const CategoriesPage: NextPage<
    IHomePage.IProps,
    IHomePage.InitialProps
> = () => {
    const home = useSelector((state: IStore) => state.Home);

    const breadcrumbsData = [
        {
            name: "Главная",
            ref: "/",
        },
        {
            name: "Категории",
            ref: undefined,
        },
    ];

    return (
        <>
            <Header />
            <Layout padding={["32px 16px 16px", null, null, null, "30px"]}>
                <Breadcrumbs breadcrumbsData={breadcrumbsData} />
                <TrendingCategories categories={home.categories} />
            </Layout>
            <Footer />
        </>
    );
};

CategoriesPage.getInitialProps = async (
    ctx: ReduxNextPageContext
): Promise<IHomePage.InitialProps> => {
    await ctx.store.dispatch(
        HomeActions.GetCategories({
            params: {
                "filter[with_stores]": "true",
            },
        })
    );
    return {
        namespacesRequired: ["common"],
        info: {
            seo: {
                description: "",
                h1: "",
                meta: {
                    title:
                        "Купонопад – промокоды и купоны на скидку интернет-магазинов.",
                    description:
                        "У нас представлены только актуальные купоны и промокоды для популярных интернет-магазинов. Лучшие акции и полный список распродаж только на Купонопад.",
                    og_title:
                        "Купонопад – промокоды и купоны на скидку интернет-магазинов.",
                    og_description:
                        "У нас представлены только актуальные купоны и промокоды для популярных интернет-магазинов. Лучшие акции и полный список распродаж только на Купонопад.",
                },
            },
        },
    };
};

export default withTranslation("common")(CategoriesPage);
