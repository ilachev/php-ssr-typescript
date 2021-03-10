// #region Global Imports
import * as React from "react";
import { NextPage } from "next";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Footer, Header, Layout } from "@Components";
import { Breadcrumbs } from "@Components/Breadcrumbs";
import { Confirm } from "@Components/Confirm";
// #endregion Local Imports

// #region Interface Imports
import { IHomePage, ReduxNextPageContext } from "@Interfaces";
import { ConfirmActions } from "@Actions";
// #endregion Interface Imports

const ConfirmPage: NextPage<IHomePage.IProps, IHomePage.InitialProps> = () => {
    const breadcrumbsData = [
        {
            name: "Главная",
            ref: "/",
        },
        {
            name: "Подтверждение регистрации",
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

                <Confirm />
            </Layout>

            <Footer />
        </>
    );
};

ConfirmPage.getInitialProps = async (
    ctx: ReduxNextPageContext
): Promise<IHomePage.InitialProps> => {
    const { uuid } = ctx.query;

    const token = undefined !== uuid ? uuid.toString() : "";

    await ctx.store.dispatch(ConfirmActions.Confirm({ token }));

    return {
        namespacesRequired: ["common"],
        info: {
            seo: {
                description: "",
                h1: "",
                meta: {
                    title: "Купонопад – подтверждение регистрации.",
                    description: "Подтверждение регистрации на Купонопад.",
                    og_title: "Купонопад – подтверждение регистрации.",
                    og_description: "Подтверждение регистрации на Купонопад.",
                },
            },
        },
    };
};

export default withTranslation("common")(ConfirmPage);
