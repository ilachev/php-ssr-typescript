// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element } from "@Components/Basic";
import { IFooter } from "./Footer";
// #endregion Local Imports

const Footer: FunctionComponent<IFooter.IProps> = ({ align }): JSX.Element => {
    return (
        <Element
            as="footer"
            css={css({
                display: ["none", null, null, null, "flex"],
                alignItems: "center",
                backgroundColor: "#fafafa",
                ...(undefined !== align ? { textAlign: align } : {}),
            })}
        >
            <Element
                css={css({
                    padding: ["32px 16px 16px", null, null, null, "30px 0"],
                    width: "1140px",
                    margin: "0 auto",
                    borderTop: "1px solid #eeeeee",
                })}
            >
                <Element
                    css={css({
                        fontSize: "14px",
                        fontWeight: "600",
                        color: "#616161",
                    })}
                >
                    {`© ${new Date().getFullYear()} Купонопад`}
                </Element>
            </Element>
        </Element>
    );
};

export { Footer };
