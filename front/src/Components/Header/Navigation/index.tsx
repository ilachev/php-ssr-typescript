// #region Global Imports
import { FunctionComponent, useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import {
    Element,
    Grid,
    Column,
    Link as StyledLink,
    Icon,
} from "@Components/Basic";
import { Link, withTranslation } from "@Server/i18n";
import { HeaderActions, StoreActions } from "@Actions";
import useAuth from "@Helpers/useAuth";
import { Picture } from "@Components/Basic/Picture";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { INavigation } from "./Navigation";
// #endregion Interface Imports

const Component: FunctionComponent<INavigation.IProps> = (): JSX.Element => {
    const profile = useSelector((state: IStore) => state.Header.profile);
    const dispatch = useDispatch();
    const [isAuth, setIsAuth] = useState(false);
    const [isDropdownExpanded, setIsDropdownExpanded] = useState(false);
    const [authInfo, setAuthInfo] = useAuth();

    useEffect(() => {
        if (undefined !== authInfo) {
            setIsAuth(true);
        } else {
            setIsAuth(false);
        }
    }, [authInfo]);

    const handleOpenRegistration = () => {
        dispatch(
            HeaderActions.Map({
                registrationModalIsOpen: true,
            })
        );
    };

    const handleSignOut = () => {
        setAuthInfo.reset();
        setIsDropdownExpanded(false);
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

    const handleOpenAuth = () => {
        dispatch(
            HeaderActions.Map({
                authModalIsOpen: true,
            })
        );
    };

    return (
        <Element>
            <Grid columnGap={30} templateColumns={5}>
                <Column>
                    <Link href="/categories">
                        <StyledLink href="/categories">Категории</StyledLink>
                    </Link>
                </Column>
                <Column>
                    <Link href="/stores">
                        <StyledLink href="/stores">Магазины</StyledLink>
                    </Link>
                </Column>
                <Column>
                    <Link href="/blog/novosti">
                        <StyledLink href="/blog/novosti">Новости</StyledLink>
                    </Link>
                </Column>
                <Column>
                    <Link href="/blog/pomoshch">
                        <StyledLink href="/blog/pomoshch">Помощь</StyledLink>
                    </Link>
                </Column>
                {isAuth ? (
                    <Column
                        css={css({
                            display: "flex",
                            color: "black",
                        })}
                    >
                        <Element
                            css={css({
                                cursor: "pointer",
                                display: "flex",
                                position: "relative",
                                alignItems: "center",
                                userSelect: "none",
                            })}
                            onClick={() =>
                                setIsDropdownExpanded(!isDropdownExpanded)
                            }
                        >
                            <Element
                                css={css({
                                    display: "flex",
                                    overflow: "hidden",
                                    position: "relative",
                                    marginRight: "2px",
                                    borderRadius: "50%",
                                    "&:before": {
                                        top: 0,
                                        left: 0,
                                        right: 0,
                                        bottom: 0,
                                        content: "",
                                        position: "absolute",
                                        backgroundColor:
                                            "rgba(33, 33, 33, 0.05)",
                                    },
                                })}
                            >
                                <Picture
                                    alt="Профиль пользователя"
                                    src={
                                        profile.avatar.url.length
                                            ? profile.avatar.url
                                            : `/static/images/default-img.svg`
                                    }
                                    imageCss={{
                                        width: "32px",
                                        height: "32px",
                                        objectFit: "cover",
                                    }}
                                />
                            </Element>
                            <Element
                                css={css({
                                    display: "flex",
                                })}
                            >
                                {isDropdownExpanded ? (
                                    <Icon name="up" />
                                ) : (
                                    <Icon name="down" />
                                )}
                            </Element>
                        </Element>
                        {isDropdownExpanded && (
                            <Element
                                css={css({
                                    top: "100%",
                                    right: 0,
                                    width: "224px",
                                    color: "#424242",
                                    border: "1px solid #f5f5f5",
                                    zIndex: 2,
                                    position: "absolute",
                                    fontSize: "16px",
                                    boxShadow: "0px 6px 12px rgb(0 0 0 / 8%)",
                                    fontWeight: 600,
                                    backgroundColor: "#ffffff",
                                    borderBottomLeftRadius: "3px",
                                    borderBottomRightRadius: "3px",
                                })}
                            >
                                <Element
                                    css={css({
                                        margin: 0,
                                        padding: 0,
                                    })}
                                    as="ul"
                                >
                                    <Element
                                        css={css({
                                            listStyle: "none",
                                        })}
                                        as="li"
                                    >
                                        <Element
                                            css={css({
                                                color: "#424242",
                                                display: "block",
                                                padding: "12px 14px",
                                                textDecoration: "none",
                                                cursor: "pointer",
                                            })}
                                            as="span"
                                            onClick={handleSignOut}
                                        >
                                            Выйти
                                        </Element>
                                    </Element>
                                </Element>
                            </Element>
                        )}
                    </Column>
                ) : (
                    <div>
                        <Column
                            css={css({
                                display: "flex",
                            })}
                        >
                            <Element
                                css={css({
                                    color: "#000000",
                                    cursor: "pointer",
                                    transition: "0.2s",
                                    fontWeight: 600,
                                    lineHeight: "20px",
                                    textDecoration: "underline",
                                    marginRight: "15px",
                                })}
                                onClick={() => handleOpenAuth()}
                            >
                                Войти
                            </Element>
                            <Element
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
                            </Element>
                        </Column>
                    </div>
                )}
            </Grid>
        </Element>
    );
};

const Navigation = withTranslation("common")(Component);

export { Navigation };
