// #region Global Imports
import { NextPageContext } from "next";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { GoActions } from "@Actions";
// #endregion Local Imports

// #region Interface Imports
// #endregion Interface Imports

const GoPage = (): JSX.Element => {
    return <></>;
};

GoPage.getInitialProps = async (ctx: NextPageContext) => {
    const { ulid } = ctx.query;

    if (typeof ulid !== "string") {
        return {
            namespacesRequired: ["common"],
            info: {},
        };
    }

    const res = await GoActions.GetReferral({ "filter[ulid]": ulid })();

    if (ctx.res) {
        if (undefined !== res.link) {
            ctx.res.setHeader("Location", res.link);
            ctx.res.statusCode = 302;
            ctx.res.end();
        } else {
            ctx.res.setHeader("Location", "/");
            ctx.res.statusCode = 302;
            ctx.res.end();
        }
    }

    return {
        namespacesRequired: ["common"],
        info: {},
    };
};

export default withTranslation("common")(GoPage);
