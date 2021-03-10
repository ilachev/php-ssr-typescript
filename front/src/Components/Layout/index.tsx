import { FunctionComponent } from "react";
import css from "@styled-system/css";

import { Element } from "@Components/Basic";
import { LayoutProps } from "./Layout";

const Layout: FunctionComponent<LayoutProps> = ({
    children,
    marginBottom,
    padding,
}): JSX.Element => {
    return (
        <Element
            css={css({
                backgroundColor: "#fafafa",
                minHeight: "calc(100vh - 150px)",
            })}
        >
            <Element
                css={css({
                    padding: padding || [
                        "32px 16px 16px",
                        null,
                        "32px 40px 40px",
                        "32px 160px 160px",
                    ],
                    margin: "64px auto 0",
                    transition: "0.2s",
                    maxWidth: "1200px",
                    "& > :not(:last-child)": {
                        marginBottom: marginBottom || 5,
                    },
                })}
            >
                {children}
            </Element>
        </Element>
    );
};

export { Layout };
