// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Text, Element } from "@Components/Basic";
import { withTranslation } from "@Server/i18n";
// #endregion Local Imports

// #region Interface Imports
import { Picture } from "@Components/Basic/Picture";
import { IHowUse } from "./HowUse";

// #endregion Interface Imports

const Component: FunctionComponent<IHowUse.IProps> = ({ t }): JSX.Element => {
    return (
        <Element>
            <Element
                css={css({
                    display: ["block", null, null, "flex"],
                    alignItems: [null, null, null, "center"],
                    justifyContent: [null, null, null, "center"],
                    marginLeft: [null, null, null, "-80px"],
                    marginBottom: ["16px"],
                })}
            >
                <Picture
                    alt="Конвейерная лента с подарочной картой, монетой и подарочной коробкой"
                    src="/static/images/conveyer-belt-img.png"
                    imageCss={{
                        width: "100%",
                        display: ["none", null, null, "block"],
                        transition: "0.2s",
                        marginLeft: "-42px",
                        opacity: "1",
                    }}
                />

                <Element>
                    <Text
                        as="h2"
                        css={css({
                            display: "block",
                            width: [null, null, "350px"],
                            fontSize: ["36px"],
                            lineHeight: ["44px"],
                            letterSpacing: ["-1px"],
                            marginBottom: ["16px"],
                        })}
                    >
                        {t("common:title")}
                    </Text>
                    <Text
                        as="span"
                        css={css({
                            display: "block",
                            width: "350px",
                            fontSize: ["20px"],
                            lineHeight: ["32px"],
                            marginBottom: ["32px"],
                        })}
                    >
                        {t("common:description")}
                    </Text>
                </Element>
            </Element>

            <Element
                css={css({
                    display: "flex",
                    flexDirection: [null, null, null, "column"],
                    justifyContent: [null, null, null, "center"],
                    alignItems: ["center"],
                })}
            >
                <Element
                    css={css({
                        margin: [
                            "0px 10px 0px -10px",
                            null,
                            null,
                            "0px 0px 8px",
                        ],
                        display: "flex",
                        alignItems: "center",
                        flexDirection: ["column", null, null, "row"],
                        justifyContent: "center",
                    })}
                >
                    <Picture
                        alt="Белая подарочная коробка с синими лентами"
                        src="/static/images/gift-box.png"
                        imageCss={{
                            width: ["100px", null, null, "158px", "195px"],
                            height: ["100px", null, null, "158px", "195px"],
                            margin: [null, null, null, "0px 10px", "0px 16px"],
                            transition: "0.2s",
                            opacity: "1",
                        }}
                    />
                    <Element
                        css={css({
                            marginBottom: "20px",
                            margin: [
                                null,
                                null,
                                null,
                                "-25px 8px 0px -2px",
                                "-25px 8px 0px -8px",
                            ],
                            minWidth: ["1px", null, null, "72px", "152px"],
                            minHeight: ["45px", null, null, "1px"],
                            backgroundColor: "#b0b0b0",
                        })}
                    />
                    <Picture
                        alt="Оранжевая сумка для покупок"
                        src="/static/images/shopping-bag.png"
                        imageCss={{
                            width: ["100px", null, null, "158px", "195px"],
                            height: ["100px", null, null, "158px", "195px"],
                            margin: [null, null, null, "0px 10px", "0px 16px"],
                            transition: "0.2s",
                            opacity: "1",
                        }}
                    />
                    <Element
                        css={css({
                            marginBottom: "20px",
                            margin: [
                                null,
                                null,
                                null,
                                "-25px 8px 0px -2px",
                                "-25px 8px 0px -8px",
                            ],
                            minWidth: ["1px", null, null, "72px", "152px"],
                            minHeight: ["45px", null, null, "1px"],
                            backgroundColor: "#b0b0b0",
                        })}
                    />
                    <Picture
                        alt="Синие, белые и оранжевые подарочные карты"
                        src="/static/images/gift-cards.png"
                        imageCss={{
                            width: ["100px", null, null, "158px", "195px"],
                            height: ["100px", null, null, "158px", "195px"],
                            margin: [null, null, null, "0px 10px", "0px 16px"],
                            transition: "0.2s",
                            opacity: "1",
                        }}
                    />
                </Element>
                <Element
                    css={css({
                        width: [null, null, null, "100%"],
                        display: [null, null, null, "flex"],
                        maxWidth: [null, null, null, "736px", "1060px"],
                        justifyContent: [null, null, null, "space-between"],
                        marginTop: [null, null, null, "-15px"],
                        marginLeft: [null, null, null, null, "5px"],
                    })}
                >
                    <Element
                        css={css({
                            width: [null, null, null, "222px", "270px"],
                            marginBottom: ["52px", null, null, "40px"],
                        })}
                    >
                        <Element
                            as="span"
                            css={css({
                                display: "block",
                                fontSize: ["28px", null, null, "36px"],
                                letterSpacing: "-0.8px",
                                lineHeight: ["37px", null, null, "44px"],
                                fontWeight: "700",
                                marginBottom: ["8px", null, null, "16px"],
                            })}
                        >
                            01.
                        </Element>
                        <Element
                            as="span"
                            css={css({
                                display: "block",
                                fontSize: ["20px", null, null, "24px"],
                                fontWeight: "600",
                                lineHeight: ["24px", null, null, "28px"],
                            })}
                        >
                            {t("common:stepOne")}
                        </Element>
                    </Element>
                    <Element
                        css={css({
                            width: [null, null, null, "222px", "270px"],
                            marginBottom: ["52px", null, null, "40px"],
                        })}
                    >
                        <Element
                            as="span"
                            css={css({
                                display: "block",
                                fontSize: ["28px", null, null, "36px"],
                                letterSpacing: "-0.8px",
                                lineHeight: ["37px", null, null, "44px"],
                                fontWeight: "700",
                                marginBottom: ["8px", null, null, "16px"],
                            })}
                        >
                            02.
                        </Element>
                        <Element
                            as="span"
                            css={css({
                                display: "block",
                                fontSize: ["20px", null, null, "24px"],
                                fontWeight: "600",
                                lineHeight: ["24px", null, null, "28px"],
                            })}
                        >
                            {t("common:stepTwo")}
                        </Element>
                    </Element>
                    <Element
                        css={css({
                            width: [null, null, null, "222px", "270px"],
                            marginBottom: ["52px", null, null, "40px"],
                        })}
                    >
                        <Element
                            as="span"
                            css={css({
                                display: "block",
                                fontSize: ["28px", null, null, "36px"],
                                letterSpacing: "-0.8px",
                                lineHeight: ["37px", null, null, "44px"],
                                fontWeight: "700",
                                marginBottom: ["8px", null, null, "16px"],
                            })}
                        >
                            03.
                        </Element>
                        <Element
                            as="span"
                            css={css({
                                display: "block",
                                fontSize: ["20px", null, null, "24px"],
                                fontWeight: "600",
                                lineHeight: ["24px", null, null, "28px"],
                            })}
                        >
                            {t("common:stepThree")}
                        </Element>
                    </Element>
                </Element>
            </Element>
        </Element>
    );
};

const HowUse = withTranslation("common")(Component);

export { HowUse };
