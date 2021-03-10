// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import { Link, withTranslation } from "@Server/i18n";
// #endregion Global Imports

// #region Local Imports
import { Element, Text } from "@Components/Basic";
// #endregion Local Imports

// #region Interface Imports
import * as React from "react";
import { IBreadcrumbs } from "./Breadcrumbs";
// #endregion Interface Imports

const Component: FunctionComponent<IBreadcrumbs.IProps> = ({
    breadcrumbsData,
    containerCss,
}): JSX.Element => {
    return (
        <Element
            css={css({
                marginBottom: "30px !important",
                fontSize: 1,
                color: "#757575",
                a: {
                    textDecoration: "none",
                    color: "#000000",
                },
                "a::visited": {
                    color: "inherit",
                },
                ...(undefined !== containerCss && { ...containerCss }),
            })}
        >
            {breadcrumbsData.map((breadcrumb, index) => {
                if (undefined !== breadcrumb.ref) {
                    return (
                        <Element as="span" key={index}>
                            <Link href={breadcrumb.ref} css={css({})}>
                                {breadcrumb.name}
                            </Link>
                            <Text> {`>`} </Text>
                        </Element>
                    );
                }

                return <Text key={index}>{breadcrumb.name}</Text>;
            })}
        </Element>
    );
};

const Breadcrumbs = withTranslation("common")(Component);

export { Breadcrumbs };
