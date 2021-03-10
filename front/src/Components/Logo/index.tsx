// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Link } from "@Server/i18n";
import { Element, Icon, Link as StyledLink } from "@Components/Basic";
// #endregion Local Imports

// #region Interface Imports
import { ILogo } from "./Logo";
// #endregion Interface Imports

const mobileStyles = css({
    display: ["flex", null, "none"],
});

const desktopStyles = css({
    display: ["none", null, "flex"],
});

export const Logo: FunctionComponent<ILogo.IProps> = ({
    isMobileMenu,
}): JSX.Element => {
    return (
        <Link href="/">
            <StyledLink href="/" css={{ width: "max-content" }}>
                {isMobileMenu && (
                    <Element>
                        <Icon width={30} height={30} name="logoSmall" />
                    </Element>
                )}

                {!isMobileMenu && (
                    <>
                        <Element css={mobileStyles}>
                            <Icon width={30} height={30} name="logoSmall" />
                        </Element>
                        <Element css={desktopStyles}>
                            <Icon width={140} height={40} name="logoFull" />
                        </Element>
                    </>
                )}
            </StyledLink>
        </Link>
    );
};
