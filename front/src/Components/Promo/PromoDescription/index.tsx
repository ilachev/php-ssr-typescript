// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import { withTranslation } from "@Server/i18n";
import * as React from "react";
// #endregion Global Imports

// #region Local Imports
import { Element } from "@Components/Basic";
// #endregion Local Imports

// #region Interface Imports
import { IPromoDescription } from "./PromoDescription";

// #endregion Interface Imports

const Component: FunctionComponent<IPromoDescription.IProps> = ({
    name,
    description,
}): JSX.Element => {
    return (
        <Element
            css={css({
                display: "flex",
                alignItems: "baseline",
                justifyContent: "space-between",
            })}
        >
            <Element
                css={css({
                    display: "inline-table",
                    marginLeft: "0px",
                    textAlign: ["center", null, "start"],
                })}
            >
                <Element
                    as="h2"
                    css={css({
                        color: "#212121",
                        fontSize: "16px",
                        fontWeight: "600",
                        lineHeight: "22px",
                        marginBottom: "16px",
                        marginTop: "0px",
                    })}
                >
                    {name}
                </Element>
                {description !== null ? (
                    <Element
                        css={css({
                            fontSize: "14px",
                            maxWidth: ["100%", null, "calc(100% - 200px)"],
                        })}
                        dangerouslySetInnerHTML={{ __html: description }}
                    />
                ) : null}
            </Element>
        </Element>
    );
};

const PromoDescription = withTranslation("common")(Component);

export { PromoDescription };
