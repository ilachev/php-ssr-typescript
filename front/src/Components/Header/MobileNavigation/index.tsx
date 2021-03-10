// #region Global Imports
import { FunctionComponent, useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import {
    Column,
    Element,
    Grid,
    Icon,
    Link as StyledLink,
    Row,
} from "@Components/Basic";
import { theme } from "@Definitions/Styled/theme";
import { Logo } from "@Components";
import { HeaderActions, StoreActions } from "@Actions";
import useAuth from "@Helpers/useAuth";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { Link, withTranslation } from "@Server/i18n";
import { IMobileNavigation } from "./MobileNavigation";
// #endregion Interface Imports

const navStyles = {
    top: 0,
    width: "100%",
    bottom: 0,
    right: "-420px",
    padding: "64px 32px 144px",
    zIndex: 1000,
    overflow: "auto",
    position: "fixed",
    maxWidth: 414,
    background: theme.colors.background.light,
    minHeight: "100vh",
    transition: "right .3s ease-out",
};

const overlayStyles = {
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    zIndex: 100,
    opacity: "0",
    position: "fixed",
    background: "#000000",
    visibility: "hidden",
    transition: "opacity .2s ease-in-out",
};

const Component: FunctionComponent<IMobileNavigation.IProps> = (): JSX.Element => {
    const isOpen = useSelector(
        (state: IStore) => state.Header.mobileMenuIsOpen
    );
    const dispatch = useDispatch();
    const [isAuth, setIsAuth] = useState(false);
    const [authInfo, setAuthInfo] = useAuth();

    useEffect(() => {
        if (undefined !== authInfo) {
            setIsAuth(true);
        } else {
            setIsAuth(false);
        }
    }, [authInfo]);

    const handleCloseMobileMenu = () => {
        dispatch(HeaderActions.CloseMobileMenu());
    };

    const handleOpenRegistration = () => {
        dispatch(
            HeaderActions.Map({
                registrationModalIsOpen: true,
                mobileMenuIsOpen: false,
            })
        );
    };

    const handleOpenAuth = () => {
        dispatch(
            HeaderActions.Map({
                authModalIsOpen: true,
                mobileMenuIsOpen: false,
            })
        );
    };

    const handleSignOut = () => {
        setAuthInfo.reset();
        dispatch(HeaderActions.CloseMobileMenu());
        dispatch(
            StoreActions.Map({
                activeCommentId: "",
                isBaseCommentFormActive: true,
                leaveComment: {
                    data: {
                        text: "",
                    },
                    errors: {
                        violations: [],
                    },
                    status: "",
                },
            })
        );
    };

    if (isOpen) {
        navStyles.right = "0px";
        overlayStyles.opacity = "0.8";
        overlayStyles.visibility = "initial";
    } else {
        navStyles.right = "-420px";
        overlayStyles.opacity = "0";
        overlayStyles.visibility = "hidden";
    }

    return (
        <>
            <Element
                css={css({
                    ...navStyles,
                })}
            >
                <Grid columnGap={0}>
                    <Element
                        css={css({
                            top: "16px",
                            left: "16px",
                            width: "26px",
                            height: "26px",
                            position: "absolute",
                        })}
                    >
                        <Logo isMobileMenu />
                    </Element>
                    <Element
                        css={css({
                            top: "16px",
                            right: "16px",
                            cursor: "pointer",
                            position: "absolute",
                        })}
                    >
                        <Icon name="cross" onClick={handleCloseMobileMenu} />
                    </Element>
                    {isAuth ? (
                        <Row
                            columnGap={0}
                            css={css({
                                color: "#000000",
                                cursor: "pointer",
                                transition: "0.2s",
                                fontWeight: 600,
                                lineHeight: "20px",
                                textDecoration: "underline",
                            })}
                            onClick={handleSignOut}
                        >
                            Выйти
                        </Row>
                    ) : (
                        <>
                            <Row
                                columnGap={0}
                                css={css({
                                    color: "#000000",
                                    cursor: "pointer",
                                    transition: "0.2s",
                                    fontWeight: 600,
                                    lineHeight: "20px",
                                    textDecoration: "underline",
                                })}
                                onClick={() => handleOpenAuth()}
                            >
                                Войти
                            </Row>
                            <Row
                                columnGap={0}
                                css={css({
                                    color: "#000000",
                                    cursor: "pointer",
                                    transition: "0.2s",
                                    fontWeight: 600,
                                    lineHeight: "20px",
                                    textDecoration: "underline",
                                })}
                                onClick={() => handleOpenRegistration()}
                            >
                                Регистрация
                            </Row>
                        </>
                    )}
                    <Row columnGap={0}>
                        <Link href="/categories">
                            <StyledLink href="/categories">
                                Категории
                            </StyledLink>
                        </Link>
                    </Row>
                    <Row columnGap={0}>
                        <Link href="/stores">
                            <StyledLink href="/stores">Магазины</StyledLink>
                        </Link>
                    </Row>
                    <Row columnGap={0}>
                        <Link href="/blog/novosti">
                            <StyledLink href="/blog/novosti">
                                Новости
                            </StyledLink>
                        </Link>
                    </Row>
                    <Row columnGap={0}>
                        <Link href="/blog/pomoshch">
                            <StyledLink href="/blog/pomoshch">
                                Помощь
                            </StyledLink>
                        </Link>
                    </Row>
                </Grid>
            </Element>
            <Element
                css={css({
                    ...overlayStyles,
                })}
                onClick={handleCloseMobileMenu}
            />
        </>
    );
};

const MobileNavigation = withTranslation("common")(Component);

export { MobileNavigation };
