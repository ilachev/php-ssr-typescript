// #region Global Imports
import { ChangeEvent, FunctionComponent } from "react";
import { useDispatch, useSelector } from "react-redux";
import css from "@styled-system/css";
import Modal from "react-modal";
import styled from "styled-components";
// #endregion Global Imports

// #region Local Imports
import { Element, Input, Text } from "@Components/Basic";
import { withTranslation } from "@Server/i18n";
import { ReCaptcha } from "@Components/Basic/ReCaptcha";
import { HeaderActions } from "@Actions";
import { useError } from "@Helpers/useError";
import { executeCaptcha } from "@Helpers/util";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { ISignUp } from "./SignUp";
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

const Component: FunctionComponent<ISignUp.IProps> = (): JSX.Element => {
    const isOpen = useSelector(
        (state: IStore) => state.Header.registrationModalIsOpen
    );
    const signUp = useSelector((state: IStore) => state.Header.signUp);
    const dispatch = useDispatch();

    const handleCloseRegistration = () => {
        dispatch(
            HeaderActions.Map({
                registrationModalIsOpen: false,
                signUp: {
                    ...signUp,
                    status: "",
                },
            })
        );
    };

    const handleOpenAuth = () => {
        dispatch(
            HeaderActions.Map({
                registrationModalIsOpen: false,
                authModalIsOpen: true,
                signUp: {
                    ...signUp,
                    status: "",
                },
            })
        );
    };

    const handleChangeName = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            HeaderActions.Map({
                signUp: {
                    ...signUp,
                    data: {
                        ...signUp.data,
                        first_name: e.target.value,
                    },
                },
            })
        );
    };

    const handleChangeSurname = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            HeaderActions.Map({
                signUp: {
                    ...signUp,
                    data: {
                        ...signUp.data,
                        last_name: e.target.value,
                    },
                },
            })
        );
    };

    const handleChangeEmail = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            HeaderActions.Map({
                signUp: {
                    ...signUp,
                    data: {
                        ...signUp.data,
                        email: e.target.value,
                    },
                },
            })
        );
    };

    const handleChangePassword = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            HeaderActions.Map({
                signUp: {
                    ...signUp,
                    data: {
                        ...signUp.data,
                        password: e.target.value,
                    },
                },
            })
        );
    };

    const handleSignUp = async (execute: () => Promise<string>) => {
        const token = await execute();
        dispatch(HeaderActions.SignUp({ ...signUp.data, token }));
    };

    const [isFirstNameError, firstNameErrorTitle] = useError(
        "first_name",
        signUp.errors.violations
    );
    const [isLastNameError, lastNameErrorTitle] = useError(
        "last_name",
        signUp.errors.violations
    );
    const [isEmailError, emailErrorTitle] = useError(
        "email",
        signUp.errors.violations
    );
    const [isPasswordError, passwordErrorTitle] = useError(
        "password",
        signUp.errors.violations
    );

    return (
        <Modal
            isOpen={isOpen}
            onRequestClose={handleCloseRegistration}
            contentLabel="Окно регистрации"
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
                    onClick={handleCloseRegistration}
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
                        Регистрация
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
                            {signUp.status === "success" ? (
                                <>
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
                                                    color: "#212121",
                                                    fontSize: "14px",
                                                    fontWeight: 600,
                                                    flexFlow: "column",
                                                })}
                                            >
                                                <Element>
                                                    Мы отправили вам на почту
                                                    письмо со ссылкой для
                                                    активации вашего аккаунта.
                                                </Element>

                                                <Element
                                                    css={css({
                                                        marginTop: "24px",
                                                    })}
                                                >
                                                    <Element
                                                        as="span"
                                                        css={css({
                                                            color: "#3d68fb",
                                                            cursor: "pointer",
                                                            transition: "0.2s",
                                                            textDecoration:
                                                                "underline",
                                                        })}
                                                        onClick={handleOpenAuth}
                                                    >
                                                        Войти
                                                    </Element>
                                                </Element>
                                            </Element>
                                        </Element>
                                    </Element>
                                </>
                            ) : (
                                <>
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
                                                    placeholder="Имя"
                                                    autoComplete="none"
                                                    value={
                                                        signUp.data.first_name
                                                    }
                                                    onChange={handleChangeName}
                                                    css={css({
                                                        borderColor: isFirstNameError
                                                            ? "#ff5252"
                                                            : "",
                                                    })}
                                                />
                                            </Element>

                                            <Element
                                                css={css({
                                                    display: "flex",
                                                    marginTop: "2px",
                                                    justifyContent:
                                                        "space-between",
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
                                                    {firstNameErrorTitle}
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
                                                    placeholder="Фамилия"
                                                    autoComplete="none"
                                                    value={
                                                        signUp.data.last_name
                                                    }
                                                    onChange={
                                                        handleChangeSurname
                                                    }
                                                    css={css({
                                                        borderColor: isLastNameError
                                                            ? "#ff5252"
                                                            : "",
                                                    })}
                                                />
                                            </Element>

                                            <Element
                                                css={css({
                                                    display: "flex",
                                                    marginTop: "2px",
                                                    justifyContent:
                                                        "space-between",
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
                                                    {lastNameErrorTitle}
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
                                                    placeholder="Email"
                                                    autoComplete="username"
                                                    type="email"
                                                    value={signUp.data.email}
                                                    onChange={handleChangeEmail}
                                                    css={css({
                                                        borderColor: isEmailError
                                                            ? "#ff5252"
                                                            : "",
                                                    })}
                                                />
                                            </Element>

                                            <Element
                                                css={css({
                                                    display: "flex",
                                                    marginTop: "2px",
                                                    justifyContent:
                                                        "space-between",
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
                                                    {emailErrorTitle}
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
                                                    autoComplete="new-password"
                                                    type="password"
                                                    value={signUp.data.password}
                                                    onChange={
                                                        handleChangePassword
                                                    }
                                                    css={css({
                                                        borderColor: isPasswordError
                                                            ? "#ff5252"
                                                            : "",
                                                    })}
                                                />
                                            </Element>

                                            <Element
                                                css={css({
                                                    display: "flex",
                                                    marginTop: "2px",
                                                    justifyContent:
                                                        "space-between",
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
                                                    {passwordErrorTitle}
                                                </Element>
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
                                        onClick={() =>
                                            handleSignUp(executeCaptcha)
                                        }
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
                                                Зарегистрироваться
                                            </Element>
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
                                        {`Уже зарегистрированы? `}
                                        <Element
                                            as="span"
                                            css={css({
                                                color: "#3d68fb",
                                                cursor: "pointer",
                                                transition: "0.2s",
                                                textDecoration: "underline",
                                            })}
                                            onClick={handleOpenAuth}
                                        >
                                            Войти
                                        </Element>
                                    </Element>
                                </>
                            )}
                        </Element>
                    </Element>
                </Element>
            </Element>

            {isOpen ? <ReCaptcha action="signUp" /> : null}
        </Modal>
    );
};

const SignUp = withTranslation("common")(Component);

export default SignUp;
export { SignUp };
