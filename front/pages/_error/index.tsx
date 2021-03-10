// #region Global Imports
import * as React from "react";
import { NextPage } from "next";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { NotFound } from "@Components";
// #endregion Local Imports

// #region Interface Imports
import { IErrorPage } from "@Interfaces";
// #endregion Interface Imports

const Error: NextPage<IErrorPage.IProps, IErrorPage.InitialProps> = ({
    t,
    statusCode,
}) => {
    switch (statusCode) {
        case 404:
            return <NotFound />;
        default:
            return (
                <div>
                    {t("common:Error")}
                    {statusCode}
                </div>
            );
    }
};

Error.getInitialProps = async ({ res, err, store }) => {
    let statusCode;

    if (res) {
        ({ statusCode } = res);
    } else if (err) {
        ({ statusCode } = err);
    }

    return {
        namespacesRequired: ["common"],
        info: store.getState().Info,
        statusCode,
    };
};

export default withTranslation("common")(Error);
