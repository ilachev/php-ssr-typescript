// #region Global Imports
import * as React from "react";
import { NextPage } from "next";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Footer, Header, Layout } from "@Components";
import { Breadcrumbs } from "@Components/Breadcrumbs";
import { ResetConfirm } from "@Components/ResetConfirm";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage, ReduxNextPageContext } from "@Interfaces";
import { ResetActions } from "@Actions";
// #endregion Interface Imports

const ResetPage: NextPage<IHomePage.IProps, IHomePage.InitialProps> = () => {
    const breadcrumbsData = [
        {
            name: "Главная",
            ref: "/",
        },
        {
            name: "Сброс пароля",
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

                <ResetConfirm />
            </Layout>

            <Footer />
        </>
    );
};

ResetPage.getInitialProps = async (
    ctx: ReduxNextPageContext
): Promise<IHomePage.InitialProps> => {
    const { uuid } = ctx.query;

    const token = undefined !== uuid ? uuid.toString() : "";

    await ctx.store.dispatch(ResetActions.Confirm({ token }));

    return {
        namespacesRequired: ["common"],
        info: {
            seo: {
                description: "",
                h1: "",
                meta: {
                    title: "Купонопад – сброс пароля.",
                    description: "Сброс пароля на Купонопад.",
                    og_title: "Купонопад – сброс пароля.",
                    og_description: "Сброс пароля на Купонопад.",
                },
            },
        },
    };
};

export default withTranslation("common")(ResetPage);
