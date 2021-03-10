// #region Global Imports
import { FunctionComponent, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { SearchInput, Element, Icon } from "@Components/Basic";
import { Logo } from "@Components";
import { theme } from "@Definitions/Styled";
import { HeaderActions } from "@Actions";
import { withTranslation } from "@Server/i18n";
import { SignUp } from "@Components/SignUp";
import { LogIn } from "@Components/LogIn";
import { PasswordRecovery } from "@Components/PasswordRecovery";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import useAuth from "@Helpers/useAuth";
import { IHeader } from "./Header";
import { Navigation } from "./Navigation";
import { MobileNavigation } from "./MobileNavigation";
// #endregion Interface Imports

const Component: FunctionComponent<IHeader.IProps> = ({ t }): JSX.Element => {
    const auth = useSelector((state: IStore) => state.Header.auth);
    const dispatch = useDispatch();
    const [authInfo, setAuthInfo] = useAuth();

    useEffect(() => {
        if (auth.access_token.length && undefined === authInfo) {
            setAuthInfo(auth as any);
            dispatch(
                HeaderActions.Map({
                    authModalIsOpen: false,
                })
            );
        }
    }, [auth]);

    const handleOpenMobileMenu = () => {
        dispatch(HeaderActions.OpenMobileMenu());
    };

    return (
        <>
            <Element
                as="header"
                css={css({
                    height: ["64px"],
                    width: ["100%"],
                    display: "flex",
                    alignItems: "center",
                    boxShadow: "0px 1px 2px rgba(0, 0, 0, 0.1)",
                    padding: ["0px 16px", "0px 16px", "0px 40px"],
                    position: "fixed",
                    top: 0,
                    zIndex: 2,
                    background: theme.colors.background.light,
                })}
            >
                <Element
                    css={css({
                        width: "100%",
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "space-between",
                    })}
                >
                    <Element
                        css={css({
                            width: ["auto", null, "170px"],
                            paddingRight: ["20px", null, "30px"],
                        })}
                    >
                        <Logo />
                    </Element>
                    <Element
                        css={css({
                            marginRight: "auto",
                            width: "100%",
                        })}
                    >
                        <SearchInput />
                    </Element>

                    <Element
                        css={css({
                            visibility: ["inherit", null, null, null, "hidden"],
                            display: ["flex", null, null, null, "none"],
                            justifySelf: ["center", "center", "end"],
                            paddingLeft: ["20px", null, "30px"],
                        })}
                    >
                        <Icon
                            css={css({
                                cursor: "pointer",
                            })}
                            name="menu"
                            size={20}
                            onClick={handleOpenMobileMenu}
                        />
                        <MobileNavigation />
                    </Element>

                    <Element
                        css={css({
                            visibility: ["hidden", null, null, null, "inherit"],
                            display: ["none", null, null, null, "flex"],
                            paddingLeft: "30px",
                        })}
                    >
                        <Navigation />
                    </Element>
                </Element>
            </Element>

            <LogIn />
            <SignUp />
            <PasswordRecovery />
        </>
    );
};

const Header = withTranslation("common")(Component);

export { Header };
