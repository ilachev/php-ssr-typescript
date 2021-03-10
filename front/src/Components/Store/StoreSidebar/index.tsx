// #region Global Imports
import { FunctionComponent } from "react";
import { withTranslation } from "@Server/i18n";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element, Text } from "@Components/Basic";
import { Picture } from "@Components/Basic/Picture";
import { useWindowSize } from "@Helpers";
import { theme } from "@Definitions/Styled/theme";
import { Info } from "@Components/Store/Info";
// #endregion Local Imports

// #region Interface Imports
import { IStoreSidebar } from "./StoreSidebar";
// #endregion Interface Imports

const Component: FunctionComponent<IStoreSidebar.IProps> = ({
    description,
    name,
    logo,
    h1,
    seoDescription,
    info,
}): JSX.Element => {
    const [width] = useWindowSize();
    const breakWidth = parseInt(theme.breakpoints[3], 10);

    return (
        <Element
            css={css({
                display: "flex",
                flexFlow: "column",
                alignItems: "center",
                minWidth: "250px",
                width: ["auto", null, null, null, "250px"],
                ul: {
                    paddingLeft: "18px",
                },
            })}
        >
            <Element
                css={css({
                    width: "auto",
                    margin: "0px auto 10px",
                    backgroundColor: [
                        "transparent",
                        null,
                        null,
                        null,
                        "#ffffff",
                    ],
                    border: ["none", null, null, null, "1px solid #e0e0e0"],
                    borderRadius: "5px",
                })}
            >
                <Element
                    css={css({
                        display: "flex",
                        alignItems: "start",
                        flexDirection: "row",
                        justifyContent: "space-between",
                        height: "100%",
                        margin: "0px auto",
                    })}
                >
                    <Element
                        css={css({
                            display: "flex",
                            alignItems: "center",
                            marginRight: "20px",
                            width: ["70px", null, null, null, "140px"],
                            height: ["70px", null, null, null, "140px"],
                            margin: [
                                "0px 20px 0px 0px",
                                null,
                                null,
                                null,
                                "40px 55px",
                            ],
                        })}
                    >
                        {undefined !== logo ? (
                            <Picture
                                alt={`Логотип ${name}`}
                                src={`${logo.url}/${logo.name}?w=140&h=140`}
                                imageCss={{
                                    width: ["70px", null, null, null, "140px"],
                                    opacity: "1",
                                    transition: "opacity 200ms",
                                }}
                            />
                        ) : null}
                    </Element>

                    <Element
                        css={css({
                            display: ["flex", null, null, null, "none"],
                            flexFlow: "column",
                            flexGrow: "1",
                            alignContent: "space-between",
                            width: "100%",
                        })}
                    >
                        {width < breakWidth ? (
                            <Element
                                css={css({
                                    display: "flex",
                                    flexFlow: "column",
                                    alignItems: "flex-start",
                                    justifyContent: "space-between",
                                    width: "100%",
                                })}
                            >
                                <Text as="h1" size={2} marginTop="0px">
                                    {h1}
                                </Text>
                                <Text as="p" size={1} marginTop="0px">
                                    {seoDescription}
                                </Text>
                            </Element>
                        ) : null}

                        <Element
                            css={css({
                                paddingBottom: "0px",
                                padding: "16px 0px 0px 0px",
                                color: "#212121",
                                fontSize: "12px",
                                fontWeight: "600",
                            })}
                        />
                    </Element>
                </Element>
            </Element>

            {width > breakWidth ? (
                <Info description={description} info={info} />
            ) : null}
        </Element>
    );
};

const StoreSidebar = withTranslation("common")(Component);

// @ts-ignore
export { StoreSidebar };
