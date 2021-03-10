// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import { useDispatch, useSelector } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { Element } from "@Components/Basic";
import { withTranslation } from "@Server/i18n";
// #endregion Local Imports

// #region Interface Imports
import { HeaderActions } from "@Actions";
import { IStore } from "@Redux/IStore";
import { IConfirm } from "./Confirm";
// #endregion Interface Imports

const Component: FunctionComponent<IConfirm.IProps> = ({ t }): JSX.Element => {
    const confirm = useSelector((state: IStore) => state.Confirm.confirm);
    const dispatch = useDispatch();

    const handleOpenAuth = () => {
        dispatch(
            HeaderActions.Map({
                authModalIsOpen: true,
            })
        );
    };

    return (
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
                        margin: ["70px auto 0px", null, null, "170px auto 0px"],
                        maxWidth: "650px",
                    })}
                >
                    <Element
                        css={css({
                            margin: "0px auto",
                            padding: ["20px", null, null, "12px"],
                            maxWidth: "500px",
                            textAlign: ["center", null, null, "left"],
                            paddingBottom: "60px",
                        })}
                    >
                        {confirm.status === "success" ? (
                            <>
                                <Element
                                    css={css({
                                        color: "#212121",
                                        fontSize: "38px",
                                        fontWeight: "600",
                                        marginBottom: "15px",
                                    })}
                                >
                                    Почта успешно подтверждена!
                                </Element>
                                <Element
                                    css={css({
                                        color: "#757575",
                                        fontSize: "14px",
                                        fontWeight: "600",
                                    })}
                                >
                                    {`Теперь вы можете `}
                                    <Element
                                        as="span"
                                        css={css({
                                            textDecoration: "underline",
                                            cursor: "pointer",
                                        })}
                                        onClick={handleOpenAuth}
                                    >
                                        авторизоваться
                                    </Element>
                                    .
                                </Element>
                            </>
                        ) : (
                            <>
                                <Element
                                    css={css({
                                        color: "#212121",
                                        fontSize: "38px",
                                        fontWeight: "600",
                                        marginBottom: "15px",
                                    })}
                                >
                                    Что-то пошло не так
                                </Element>
                                <Element
                                    css={css({
                                        color: "#757575",
                                        fontSize: "14px",
                                        fontWeight: "600",
                                    })}
                                >
                                    Почта не существует либо занята.
                                </Element>
                            </>
                        )}
                    </Element>
                </Element>
            </Element>
        </Element>
    );
};

const Confirm = withTranslation("common")(Component);

export { Confirm };
