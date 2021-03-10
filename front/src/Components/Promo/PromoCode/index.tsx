// #region Global Imports
import { FunctionComponent, useEffect, useState } from "react";
import { useSelector } from "react-redux";
import css from "@styled-system/css";
import Modal from "react-modal";
// #endregion Global Imports

// #region Local Imports
import { Element, Text } from "@Components/Basic";
import { PromoDescription } from "@Components/Promo/PromoDescription";
import { withTranslation } from "@Server/i18n";
import { PromoCodeButton } from "@Components/Promo/PromoCodeButton";
import useAuth from "@Helpers/useAuth";
import useActivePromoCode from "@Helpers/useActivePromoCode";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import useEffectOnce from "@Helpers/useEffectOnce";
import { IPromoCode } from "./PromoCode";
// #endregion Interface Imports

Modal.setAppElement("#__next");

const customStyles = {
    content: {
        top: "50%",
        left: "50%",
        right: "auto",
        bottom: "auto",
        marginRight: "-50%",
        transform: "translate(-50%, -50%)",
    },
    overlay: {
        backgroundColor: "rgba(0, 0, 0, 0.5)",
        zIndex: 2,
        transition: "opacity .3s cubic-bezier(0,0,.2,1)",
    },
};

const Component: FunctionComponent<IPromoCode.IProps> = ({
    promo,
}): JSX.Element => {
    const isPromoCodeClicked = useSelector(
        (state: IStore) => state.Store.isPromoCodeClicked
    );
    const [isAuth, setIsAuth] = useState(false);
    const [modalIsOpen, setModalIsOpen] = useState(false);
    const [authInfo] = useAuth();
    const [activePromo, setActivePromo] = useActivePromoCode();

    const handleOpenModal = (e: Event) => {
        e.preventDefault();
        setActivePromo(promo.id as any);
        window.open(window.location.href, "_blank");
        window.location.assign(promo.referral);
    };

    const handleCloseModal = () => {
        setModalIsOpen(false);
    };

    useEffect(() => {
        if (authInfo) {
            setIsAuth(true);
        }

        return () => setIsAuth(false);
    }, [authInfo]);

    useEffectOnce(() => {
        if (activePromo === promo.id) {
            setModalIsOpen(true);
            setActivePromo.reset();
        }

        return () => setModalIsOpen(false);
    });

    return (
        <>
            <Modal
                isOpen={modalIsOpen}
                onRequestClose={handleCloseModal}
                contentLabel="Post modal"
                style={customStyles}
            >
                <Element
                    css={css({
                        position: "relative",
                    })}
                >
                    <Element
                        css={css({
                            top: "18px",
                            right: "16px",
                            cursor: "pointer",
                            position: "absolute",
                            justifyContent: "space-between",
                        })}
                        onClick={handleCloseModal}
                    >
                        <Element
                            css={css({
                                display: "flex",
                            })}
                        >
                            <Text size={2}>✖️</Text>
                        </Element>
                    </Element>
                </Element>
                <Element
                    css={css({
                        position: "relative",
                        textAlign: "center",
                    })}
                >
                    <Element
                        css={css({
                            margin: "78px 70px 70px",
                            fontSize: "24px",
                            fontWeight: 600,
                        })}
                    >
                        {promo.name}
                    </Element>

                    <PromoCodeButton
                        code={promo.code}
                        referral={promo.referral}
                        modalIsOpen={modalIsOpen}
                    />
                </Element>
            </Modal>

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
                            {(promo.discount_unit === null ||
                                promo.discount_unit === "rouble") &&
                            promo.discount !== null ? (
                                <Element>руб.</Element>
                            ) : null}
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
                                ".PromoCode__Button:hover ~ .PromoCode__Button-border": {
                                    width: "15px",
                                    height: "15px",
                                    borderWidth: "15px",
                                },
                            })}
                        >
                            {!isPromoCodeClicked && !isAuth ? (
                                <Element
                                    as="button"
                                    className="PromoCode__Button"
                                    css={css({
                                        cursor: "pointer",
                                        color: "#ffffff",
                                        width: "190px",
                                        height: "40px",
                                        transition: "0.2s",
                                        border: "none",
                                        borderRadius: "5px",
                                        backgroundColor: "#3d68fb",
                                        ":hover": {
                                            backgroundColor: "#6083fb",
                                        },
                                    })}
                                    onClick={handleOpenModal}
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
                                        Показать код
                                    </Element>
                                </Element>
                            ) : (
                                <PromoCodeButton
                                    code={promo.code}
                                    referral={promo.referral}
                                    modalIsOpen={modalIsOpen}
                                />
                            )}

                            <Element
                                className="PromoCode__Button-border"
                                css={css({
                                    right: "0px",
                                    width: "10px",
                                    bottom: "0px",
                                    height: "10px",
                                    position: "absolute",
                                    background: "#2e4ebe",
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
                                    margin: [
                                        "10px 0px",
                                        null,
                                        "-18px 0px 0px 0px",
                                    ],
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
        </>
    );
};

const PromoCode = withTranslation("common")(Component);

export { PromoCode };
