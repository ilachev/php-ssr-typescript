// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import { withTranslation } from "@Server/i18n";
// #endregion Global Imports

// #region Local Imports
import { Element, Text } from "@Components/Basic";
import { PromoDescription } from "@Components/Promo/PromoDescription";
// #endregion Local Imports

// #region Interface Imports
import { ICoupon } from "./Coupon";
// #endregion Interface Imports

const Component: FunctionComponent<ICoupon.IProps> = ({
    promo,
}): JSX.Element => {
    const handleOpenReferral = (e: Event) => {
        e.preventDefault();
        window.open(window.location.href, "_blank");
        window.location.assign(promo.referral);
    };

    return (
        <Element
            css={css({
                width: "100%",
                border: "solid 1px #e0e0e0",
                margin: "0px auto 10px",
                display: "flex",
                flexFlow: ["column", null, "row"],
                minWidth: "250px",
                boxShadow: "0px 2px 9px 0px rgba(0, 0, 0, 0.02)",
                minHeight: "170px",
                transition: "0.2s",
                flexShrink: "0",
                borderRadius: "5px",
                justifyContent: "space-between",
                backgroundColor: "#ffffff",
            })}
        >
            <Element
                css={css({
                    cursor: "auto",
                    display: "flex",
                    padding: ["15px", null, null, "26px 0px 28px"],
                    minWidth: "110px",
                    alignItems: "center",
                    borderRight: "solid 1px #e0e0e0",
                    flexDirection: "column",
                    justifyContent: "space-between",
                })}
            >
                <Element
                    css={css({
                        textAlign: "center",
                    })}
                >
                    <Element
                        css={css({
                            color: "#212121",
                            margin: "0px auto",
                            fontSize: "20px",
                            fontWeight: "bold",
                            lineHeight: "1.04",
                            textTransform: "uppercase",
                        })}
                    >
                        {promo.discount !== null &&
                        promo.discount_unit === "rouble" ? (
                            <Element>{promo.discount}</Element>
                        ) : null}
                        {promo.discount !== null &&
                        promo.discount_unit === "dollar" ? (
                            <Element>${promo.discount}</Element>
                        ) : null}
                        {promo.discount !== null &&
                        promo.discount_unit === "euro" ? (
                            <Element>€{promo.discount}</Element>
                        ) : null}
                        {promo.discount !== null &&
                        promo.discount_unit === "percent" ? (
                            <Element>{promo.discount}%</Element>
                        ) : null}
                    </Element>
                    <Element
                        css={css({
                            color: "#424242",
                            fontSize: "14px",
                            fontWeight: "600",
                            letterSpacing: "1px",
                            textTransform: "uppercase",
                        })}
                    >
                        скидка
                    </Element>
                </Element>
            </Element>

            <Element
                css={css({
                    width: "100%",
                    cursor: "auto",
                    display: "flex",
                    padding: ["15px", null, "24px 0px 20px"],
                    position: "relative",
                    flexWrap: "wrap",
                    minWidth: "0px",
                    marginLeft: ["0px", null, "25px"],
                    marginRight: ["0px", null, "28px"],
                    flexDirection: "column",
                    justifyContent: "space-between",
                })}
            >
                <PromoDescription
                    name={promo.name}
                    description={promo.description}
                />

                <Element
                    css={css({
                        top: "50%",
                        right: "0px",
                        display: "flex",
                        flexFlow: ["column", null, "row"],
                        alignItems: "center",
                        margin: "10px 0px",
                        position: "initial",
                    })}
                >
                    <Element
                        css={css({
                            height: "40px",
                            overflow: "hidden",
                            display: "flex",
                            justifyContent: ["center"],
                            position: ["relative", null, "absolute"],
                            top: [null, null, "50%"],
                            right: [null, null, "0px"],
                            margin: ["10px 0px", null, "-18px 0px 0px 0px"],
                            borderRadius: "5px",
                            ".Coupon__Button:hover ~ .Coupon__Button-border": {
                                width: "15px",
                                height: "15px",
                                borderWidth: "15px",
                            },
                        })}
                    >
                        <Element
                            as="button"
                            className="Coupon__Button"
                            css={css({
                                cursor: "pointer",
                                color: "#ffffff",
                                width: "190px",
                                height: "40px",
                                transition: "0.2s",
                                border: "none",
                                borderRadius: "5px",
                                backgroundColor: "#37b1b8",
                                ":hover": {
                                    backgroundColor: "#5bbfc4",
                                },
                            })}
                            onClick={handleOpenReferral}
                        >
                            <Element
                                css={css({
                                    color: "#ffffff",
                                    fontSize: "14px",
                                    textAlign: "center",
                                    fontWeight: "600",
                                    lineHeight: "20px",
                                })}
                            >
                                Получить купон
                            </Element>
                        </Element>
                        <Element
                            className="Coupon__Button-border"
                            css={css({
                                right: "0px",
                                width: "10px",
                                bottom: "0px",
                                height: "10px",
                                position: "absolute",
                                background: "#237176",
                                transition: "0.2s",
                                borderLeft: "10px solid transparent",
                                borderBottom: "10px solid #dedede",
                                pointerEvents: "none",
                                borderTopLeftRadius: "3px",
                            })}
                        />
                    </Element>

                    {undefined !== promo.end_date ? (
                        <Element
                            css={css({
                                overflow: "hidden",
                                display: "flex",
                                position: ["relative", null, "absolute"],
                                top: [null, null, "77%"],
                                right: [null, null, "0px"],
                                margin: ["10px 0px", null, "-18px 0px 0px 0px"],
                                fontSize: "12px",
                            })}
                        >
                            {!promo.is_expired ? (
                                <Element
                                    css={css({
                                        minWidth: "190px",
                                    })}
                                >
                                    <Text size={3}>⏰</Text>
                                    <Text> Активен до </Text>
                                    {promo.end_date}
                                </Element>
                            ) : (
                                <Element
                                    css={css({
                                        minWidth: "190px",
                                    })}
                                >
                                    <Text size={3}>😔</Text>
                                    <Text> Истёк </Text>
                                    {promo.end_date}
                                </Element>
                            )}
                        </Element>
                    ) : null}
                </Element>
            </Element>
        </Element>
    );
};

const Coupon = withTranslation("common")(Component);

export { Coupon };
