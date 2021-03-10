// #region Global Imports
import * as React from "react";
import { NextPage } from "next";
import { useSelector } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import {
    Header,
    Layout,
    TrendingStores,
    TrendingCategories,
    HowUse,
} from "@Components";
import { IStore } from "@Redux/IStore";
import { HomeActions } from "@Actions";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage, ReduxNextPageContext } from "@Interfaces";
// #endregion Interface Imports

const Home: NextPage<IHomePage.IProps, IHomePage.InitialProps> = () => {
    const home = useSelector((state: IStore) => state.Home);

    return (
        <>
            <Header />
            <Layout padding={["32px 16px 16px", null, null, null, "30px"]}>
                <TrendingStores stores={home.stores} />
                <TrendingCategories categories={home.categories} />
                {/* <BestPromo /> */}
                <HowUse />
            </Layout>
        </>
    );
};

Home.getInitialProps = async (
    ctx: ReduxNextPageContext
): Promise<IHomePage.InitialProps> => {
    await ctx.store.dispatch(
        HomeActions.GetCategories({
            params: {
                "filter[with_stores]": "true",
            },
        })
    );
    await ctx.store.dispatch(
        HomeActions.GetStores({
            params: {},
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

export default withTranslation("common")(Home);
