// #region Global Imports
import { useEffect, useState } from "react";
import { NextPage } from "next";
import { useDispatch, useSelector } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Footer, Header, Layout, Store as StoreMain } from "@Components";

import { StoreActions } from "@Actions";
import { Breadcrumbs } from "@Components/Breadcrumbs";
import useAuth from "@Helpers/useAuth";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage, IStore, ReduxNextPageContext } from "@Interfaces";
import * as React from "react";
// #endregion Interface Imports

const Store: NextPage<IHomePage.IProps, IHomePage.InitialProps> = () => {
    const store = useSelector((state: IStore) => state.Store.store);
    const seo = useSelector((state: IStore) => state.Info.seo);
    const [isAuth, setIsAuth] = useState(false);
    const dispatch = useDispatch();
    const [authInfo] = useAuth();

    useEffect(() => {
        if (isAuth) {
            dispatch(
                StoreActions.GetComments({
                    params: {
                        "filter[slug]": store.slug,
                        per_page: 20,
                        page: 1,
                        sort: "date",
                        direction: "desc",
                    },
                    authInfo: authInfo!,
                })
            );
            dispatch(
                StoreActions.GetCommentsCount({
                    params: {
                        "filter[slug]": store.slug,
                    },
                    authInfo: authInfo!,
                })
            );
        }
    }, [isAuth, dispatch, store.slug]);

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
            name: "Магазины",
            ref: "/stores",
        },
        {
            name: `${store.name}`,
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
                <StoreMain
                    store={store}
                    h1={seo.h1}
                    seoDescription={seo.description}
                />
            </Layout>

            <Footer />
        </>
    );
};

Store.getInitialProps = async (
    ctx: ReduxNextPageContext
): Promise<IHomePage.InitialProps> => {
    const { slug, page } = ctx.query;

    await ctx.store.dispatch(StoreActions.Reset());

    const res = await ctx.store.dispatch(
        StoreActions.GetStore({
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
        StoreActions.GetStorePageInfo({
            params: {
                slug,
            },
        })
    );
    await ctx.store.dispatch(
        StoreActions.GetPromosCount({
            params: {
                "filter[slug]": slug,
                "filter[is_expired]": false,
            },
        })
    );
    await ctx.store.dispatch(
        StoreActions.GetPromos({
            params: {
                "filter[slug]": slug,
                "filter[type]": "all",
                "filter[is_expired]": false,
                per_page: 10,
                page: undefined !== page ? page : 1,
                sort: "end_date",
                direction: "asc",
            },
        })
    );
    await ctx.store.dispatch(
        StoreActions.GetOldPromos({
            params: {
                "filter[slug]": slug,
                "filter[type]": "all",
                "filter[is_expired]": true,
                per_page: 5,
                page: 1,
                sort: "end_date",
                direction: "desc",
            },
        })
    );
    await ctx.store.dispatch(
        StoreActions.GetComments({
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
        StoreActions.GetCommentsCount({
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

export default withTranslation("common")(Store);
