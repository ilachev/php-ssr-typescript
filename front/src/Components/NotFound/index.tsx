// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import { Link, withTranslation } from "@Server/i18n";
// #endregion Global Imports

// #region Local Imports
import { Element } from "@Components/Basic";
import { Picture } from "@Components/Basic/Picture";
import { Header } from "@Components/Header";
import { Layout } from "@Components/Layout";
// #endregion Local Imports

// #region Interface Imports
import { Footer } from "@Components/Footer";
import { INotFound } from "./NotFound";
// #endregion Interface Imports

const Component: FunctionComponent<INotFound.IProps> = (): JSX.Element => {
    return (
        <>
            <Header />
            <Layout padding={["32px 16px 16px", null, null, null, "30px"]}>
                <Element
                    css={css({
                        display: "flex",
                        flex: "1 1 auto",
                        flexDirection: "column",
                        justifyContent: "space-between",
                    })}
                >
                    <Element>
                        <Element
                            css={css({
                                margin: [
                                    "70px auto 0px",
                                    null,
                                    null,
                                    "170px auto 0px",
                                ],
                                maxWidth: "650px",
                            })}
                        >
                            <Picture
                                alt="Not found"
                                src="/static/images/not-found.gif"
                                imageCss={{
                                    display: "block",
                                    margin: "0px auto",
                                    float: [null, null, null, "left"],
                                }}
                            />
                            <Element
                                css={css({
                                    float: [null, null, null, "right"],
                                    margin: "0px auto",
                                    padding: ["20px", null, null, "12px"],
                                    maxWidth: "500px",
                                    textAlign: ["center", null, null, "left"],
                                    paddingBottom: "60px",
                                })}
                            >
                                <Element
                                    css={css({
                                        color: "#212121",
                                        fontSize: "38px",
                                        fontWeight: "600",
                                        marginBottom: "15px",
                                    })}
                                >
                                    К сожалению, нам не удалось найти страницу,
                                    которую вы ищете.
                                </Element>
                                <Element
                                    css={css({
                                        color: "#757575",
                                        fontSize: "14px",
                                        fontWeight: "600",
                                    })}
                                >
                                    {`Попробуйте ввести адрес еще раз или просто вернитесь на `}
                                    <Link href="/">
                                        <a href="/">главную страницу</a>
                                    </Link>
                                    {` .`}
                                </Element>
                            </Element>
                        </Element>
                    </Element>
                </Element>
            </Layout>
            <Footer />
        </>
    );
};

const NotFound = withTranslation("common")(Component);

export { NotFound };
