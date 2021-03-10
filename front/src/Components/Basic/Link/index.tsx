// #region Global Imports
import React from "react";
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled/theme";
import { ILink } from "./Link";
import { Text } from "../Text";
// #endregion Local Imports

const LinkElement = styled(Text).attrs((p) => ({
    as: ((p as unknown) as { as: string }).as || "a",
}))<ILink.IProps>(
    css({
        cursor: "pointer",
        textDecoration: "none",
        transition: "color .2s ease-in-out",
        transitionDuration: theme.speeds[2],
        ":visited": {
            color: theme.colors.visitedLink,
        },
        ":hover, :focus": {
            color: theme.colors.hoverLink,
        },
    })
);

export const Link: React.FC<ILink.IProps> = React.forwardRef((props, ref) => {
    return (
        <LinkElement
            ref={ref}
            rel={props.target === "_blank" ? "noopener noreferrer" : null}
            as="a"
            {...props}
        />
    );
});
