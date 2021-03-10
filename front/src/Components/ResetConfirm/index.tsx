// #region Global Imports
import { ChangeEvent, FunctionComponent } from "react";
import css from "@styled-system/css";
import { useDispatch, useSelector } from "react-redux";
import styled from "styled-components";
// #endregion Global Imports

// #region Local Imports
import { Element, Input } from "@Components/Basic";
import { withTranslation } from "@Server/i18n";
import { HeaderActions, ResetActions } from "@Actions";
import { useError } from "@Helpers/useError";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { IResetConfirm } from "./ResetConfirm";
// #endregion Interface Imports

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

const Component: FunctionComponent<IResetConfirm.IProps> = (): JSX.Element => {
    const confirm = useSelector((state: IStore) => state.Reset.confirm);
    const reset = useSelector((state: IStore) => state.Reset.reset);
    const dispatch = useDispatch();

    const handleOpenAuth = () => {
        dispatch(
            HeaderActions.Map({
                authModalIsOpen: true,
            })
        );
    };

    const handleReset = () => {
        const { token } = confirm.data;
        dispatch(ResetActions.Reset({ ...reset.data, token }));
    };

    const handleChangePassword = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            ResetActions.Map({
                reset: {
                    ...reset,
                    data: {
                        ...reset.data,
                        password: e.target.value,
                    },
                },
            })
        );
    };

    const [isPasswordError, passwordErrorTitle] = useError(
        "password",
        reset.errors.violations
    );
    const [, tokenErrorTitle] = useError("token", reset.errors.violations);

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
                        {confirm.status !== "success" ? (
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
                                    Неправильный или уже подтверждённый токен
                                    сброса пароля.
                                </Element>
                            </>
                        ) : (
                            <></>
                        )}
                        {confirm.status === "success" &&
                        reset.status === "success" ? (
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
                                                fontSize: "38px",
                                                lineHeight: "38px",
                                                fontWeight: 600,
                                                flexFlow: "column",
                                            })}
                                        >
                                            <Element>
                                                Пароль успешно изменён.
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
                                                        fontSize: "16px",
                                                        fontWeight: 600,
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
                            <></>
                        )}
                        {confirm.status === "success" &&
                        reset.status !== "success" ? (
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
                                                placeholder="Пароль"
                                                autoComplete="none"
                                                type="password"
                                                value={reset.data.password}
                                                onChange={handleChangePassword}
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
                                                justifyContent: "space-between",
                                            })}
                                        >
                                            {tokenErrorTitle ? (
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
                                                    {tokenErrorTitle}
                                                </Element>
                                            ) : (
                                                <></>
                                            )}
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
                                    onClick={handleReset}
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
                                            Сменить пароль
                                        </Element>
                                    </Element>
                                </Element>
                            </>
                        ) : (
                            <></>
                        )}
                    </Element>
                </Element>
            </Element>
        </Element>
    );
};

const ResetConfirm = withTranslation("common")(Component);

export { ResetConfirm };
