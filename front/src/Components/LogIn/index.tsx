// #region Global Imports
import { ChangeEvent, FunctionComponent } from "react";
import css from "@styled-system/css";
import styled from "styled-components";
import Modal from "react-modal";
import { useDispatch, useSelector } from "react-redux";
import getConfig from "next/config";
// #endregion Global Imports

// #region Local Imports
import { Element, Input, Text } from "@Components/Basic";
import { withTranslation } from "@Server/i18n";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { HeaderActions } from "@Actions";
import { useError } from "@Helpers/useError";
import { ILogIn } from "./LogIn";
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

const InputComponent = styled(Input)(
    css({
        color: "#212121",
        width: "100%",
        border: "1px solid #bdbdbd",
        outline: "none",
        padding: "12px 10px",
        transition: "0.2s",
        fontWeight: 600,
        borderRadius: "5px",
        height: "48px",
        fontSize: "16px",
        paddingTop: "15px",
    })
);

const {
    publicRuntimeConfig: { OAUTH2_CLIENT_ID },
} = getConfig();

const Component: FunctionComponent<ILogIn.IProps> = ({ t }): JSX.Element => {
    const logIn = useSelector((state: IStore) => state.Header.logIn);
    const isOpen = useSelector((state: IStore) => state.Header.authModalIsOpen);
    const dispatch = useDispatch();

    const handleCloseAuth = () => {
        dispatch(
            HeaderActions.Map({
                authModalIsOpen: false,
            })
        );
    };

    const handleOpenRegistration = () => {
        dispatch(
            HeaderActions.Map({
                registrationModalIsOpen: true,
                authModalIsOpen: false,
            })
        );
    };

    const handleOpenRecovery = () => {
        dispatch(
            HeaderActions.Map({
                recoveryModalIsOpen: true,
                authModalIsOpen: false,
            })
        );
    };

    const handleChangeEmail = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            HeaderActions.Map({
                logIn: {
                    ...logIn,
                    data: {
                        ...logIn.data,
                        username: e.target.value,
                    },
                },
            })
        );
    };

    const handleChangePassword = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            HeaderActions.Map({
                logIn: {
                    ...logIn,
                    data: {
                        ...logIn.data,
                        password: e.target.value,
                    },
                },
            })
        );
    };

    const handleLogIn = () => {
        dispatch(
            HeaderActions.LogIn({
                ...logIn.data,
                grant_type: "password",
                client_id: OAUTH2_CLIENT_ID,
            })
        );
    };

    return (
        <Modal
            isOpen={isOpen}
            onRequestClose={handleCloseAuth}
            contentLabel="Окно авторизации"
            style={customStyles}
        >
            <Element
                as="form"
                css={css({
                    position: "relative",
                })}
                onSubmit={(e: Event) => e.preventDefault()}
            >
                <Element
                    css={css({
                        top: "18px",
                        right: "16px",
                        cursor: "pointer",
                        position: "absolute",
                        justifyContent: "space-between",
                        zIndex: 1,
                    })}
                    onClick={handleCloseAuth}
                >
                    <Element
                        css={css({
                            display: "flex",
                        })}
                    >
                        <Text size={2}>✖️</Text>
                    </Element>
                </Element>

                <Element
                    css={css({
                        margin: "0 auto",
                        padding: "40px 30px",
                        position: "relative",
                        maxWidth: "360px",
                        textAlign: "left",
                        borderRadius: "5px",
                        backgroundColor: "#ffffff",
                    })}
                >
                    <Element
                        css={css({
                            color: "#212121",
                            fontSize: "16px",
                            fontWeight: 600,
                            marginBottom: "20px",
                        })}
                    >
                        Авторизация
                    </Element>
                    <Element
                        css={css({
                            width: "100%",
                        })}
                    >
                        <Element
                            css={css({
                                width: "100%",
                                display: "flex",
                                flexDirection: "column",
                            })}
                        >
                            <Element>
                                <Element
                                    css={css({
                                        transition: "0.2s",
                                        lineHeight: "20px",
                                    })}
                                >
                                    <Element
                                        css={css({
                                            width: "100%",
                                            display: "flex",
                                            position: "relative",
                                            transition: "0.2s",
                                        })}
                                    >
                                        <InputComponent
                                            placeholder="Email"
                                            type="email"
                                            autoComplete="username"
                                            value={logIn.data.username}
                                            onChange={handleChangeEmail}
                                            css={css({
                                                borderColor: logIn.errors.error
                                                    .length
                                                    ? "#ff5252"
                                                    : "",
                                            })}
                                        />
                                    </Element>

                                    <Element
                                        css={css({
                                            display: "flex",
                                            marginTop: "2px",
                                            justifyContent: "space-between",
                                        })}
                                    >
                                        <Element
                                            css={css({
                                                color: "#ff5252",
                                                opacity: 1,
                                                overflow: "hidden",
                                                fontSize: "11px",
                                                transition: "0.2s",
                                                fontWeight: 600,
                                                lineHeight: "15px",
                                                userSelect: "none",
                                                whiteSpace: "nowrap",
                                                height: "15px",
                                            })}
                                        >
                                            {logIn.errors.error.length
                                                ? `Неправильная почта либо пароль`
                                                : ``}
                                        </Element>
                                    </Element>
                                </Element>
                            </Element>

                            <Element>
                                <Element
                                    css={css({
                                        transition: "0.2s",
                                        lineHeight: "20px",
                                    })}
                                >
                                    <Element
                                        css={css({
                                            width: "100%",
                                            display: "flex",
                                            position: "relative",
                                            transition: "0.2s",
                                        })}
                                    >
                                        <InputComponent
                                            placeholder="Пароль"
                                            type="password"
                                            autoComplete="current-password"
                                            value={logIn.data.password}
                                            onChange={handleChangePassword}
                                            css={css({
                                                borderColor: logIn.errors.error
                                                    .length
                                                    ? "#ff5252"
                                                    : "",
                                            })}
                                        />
                                    </Element>

                                    <Element
                                        css={css({
                                            display: "flex",
                                            marginTop: "2px",
                                            justifyContent: "space-between",
                                        })}
                                    >
                                        <Element
                                            css={css({
                                                color: "#ff5252",
                                                opacity: 1,
                                                overflow: "hidden",
                                                fontSize: "11px",
                                                transition: "0.2s",
                                                fontWeight: 600,
                                                lineHeight: "15px",
                                                userSelect: "none",
                                                whiteSpace: "nowrap",
                                                height: "15px",
                                            })}
                                        />
                                    </Element>
                                </Element>
                            </Element>

                            <Element
                                as="button"
                                css={css({
                                    cursor: "pointer",
                                    height: "48px",
                                    outline: "none",
                                    padding: "0px 16px",
                                    background: "none",
                                    boxShadow: "none",
                                    transition: "all 0.2s ease 0s",
                                    textShadow: "none",
                                    borderStyle: "solid",
                                    borderWidth: "1px",
                                    borderRadius: "5px",
                                    borderColor: "rgb(204, 75, 6)",
                                    backgroundColor: "rgb(204, 75, 6)",
                                    width: "100%",
                                    overflow: "hidden",
                                })}
                                onClick={handleLogIn}
                            >
                                <Element
                                    css={css({
                                        width: "100%",
                                        display: "flex",
                                        alignItems: "center",
                                        justifyContent: "center",
                                    })}
                                >
                                    <Element
                                        css={css({
                                            fontSize: "16px",
                                            color: "rgb(255, 255, 255)",
                                            order: 2,
                                            overflow: "hidden",
                                            fontWeight: 600,
                                            whiteSpace: "nowrap",
                                            fontStretch: "normal",
                                            textOverflow: "ellipsis",
                                            letterSpacing: "normal",
                                        })}
                                    >
                                        Войти
                                    </Element>
                                </Element>
                            </Element>

                            <Element
                                css={css({
                                    color: "#757575",
                                    fontSize: "14px",
                                    marginTop: "8px",
                                    fontWeight: "600",
                                    lineHeight: "16px",
                                })}
                            >
                                <Element
                                    as="span"
                                    css={css({
                                        cursor: "pointer",
                                        transition: "0.2s",
                                        textDecoration: "underline",
                                    })}
                                    onClick={handleOpenRecovery}
                                >
                                    Забыли пароль?
                                </Element>
                            </Element>

                            <Element
                                css={css({
                                    color: "#212121",
                                    fontSize: "14px",
                                    marginTop: "24px",
                                    fontWeight: 600,
                                })}
                            >
                                Ещё не зарегистрированы?{" "}
                                <Element
                                    as="span"
                                    css={css({
                                        color: "#3d68fb",
                                        cursor: "pointer",
                                        transition: "0.2s",
                                        textDecoration: "underline",
                                    })}
                                    onClick={handleOpenRegistration}
                                >
                                    Зарегистрироваться
                                </Element>
                            </Element>
                        </Element>
                    </Element>
                </Element>
            </Element>
        </Modal>
    );
};

const LogIn = withTranslation("common")(Component);

export default LogIn;
export { LogIn };
