// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import * as React from "react";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Element } from "@Components/Basic";
import { Coupon } from "./Coupon";
import { Discount } from "./Discount";
import { PromoCode } from "./PromoCode";
// #endregion Local Imports

// #region Interface Imports
import { IPromo } from "./Promo";
// #endregion Interface Imports

const Component: FunctionComponent<IPromo.IProps> = ({
    promo,
}): JSX.Element => {
    return (
        <Element
            css={css({
                width: "100%",
                margin: "0px auto 10px",
                display: "flex",
                minWidth: "250px",
                minHeight: "170px",
                transition: "0.2s",
                flexShrink: "0",
                borderRadius: "5px",
                justifyContent: "space-between",
                ...(promo.is_expired && {
                    filter: "grayscale(1)",
                    pointerEvents: "none",
                }),
            })}
        >
            {promo.type === "coupon" ? <Coupon promo={promo} /> : null}

            {promo.type === "discount" ? <Discount promo={promo} /> : null}

            {promo.type === "promo-code" ? <PromoCode promo={promo} /> : null}
        </Element>
    );
};

const Promo = withTranslation("common")(Component);

export { Promo };
