// #region Global Imports
import React from "react";
import styled, { keyframes } from "styled-components";
import VisuallyHidden from "@reach/visually-hidden";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled/theme";
import { merge } from "@Helpers/util";
import { IButton } from "./Button";
import { Element } from "../Element";
// #endregion Local Imports

const commonStyles = {
    display: "inline-flex",
    justifyContent: "center",
    alignItems: "center",
    flex: "none", // as a flex child
    cursor: "pointer",
    fontFamily: "Inter, sans-serif",
    paddingY: 0,
    paddingX: 2,
    height: "26px", // match with inputs
    width: "100%",
    fontSize: "1em",
    fontWeight: "medium",
    lineHeight: 1, // trust the height
    border: "none",
    borderRadius: "5px",
    transition: "all ease-in",
    textDecoration: "none",
    transitionDuration: theme.speeds[2],
    ":focus": {
        outline: "none",
        boxShadow: "0 0 2px 2px rgba(243, 128, 32, 0.5)",
    },
    ":active:not(:disabled)": {
        transform: "scale(0.98)",
    },
    ":disabled": {
        opacity: "0.4",
        cursor: "not-allowed",
    },
    '&[data-loading="true"]': {
        opacity: 1,
        cursor: "default",
    },
};

const variantStyles = {
    primary: {
        backgroundColor: theme.colors.button.primary.background,
        color: theme.colors.button.primary.foreground,
        ":hover:not(:disabled)": theme.colors.button.primary.hoverBackground,
        ":focus:not(:disabled)": theme.colors.button.primary.hoverBackground,
        ":focus": {
            outline: "none",
            boxShadow: "0 0 2px 2px rgba(243, 128, 32, 0.5)",
        },
    },
    secondary: {
        backgroundColor: theme.colors.button.secondary.background,
        color: theme.colors.button.secondary.foreground,
        ":hover:not(:disabled)": theme.colors.button.secondary.hoverBackground,
        ":focus:not(:disabled)": theme.colors.button.secondary.hoverBackground,
    },
    link: {
        backgroundColor: theme.colors.button.link.background,
        color: theme.colors.button.link.foreground,
        ":hover:not(:disabled)": theme.colors.button.link.hoverBackground,
        ":focus:not(:disabled)": theme.colors.button.link.hoverBackground,
    },
    danger: {
        backgroundColor: theme.colors.button.danger.background,
        color: theme.colors.button.danger.foreground,
        ":hover:not(:disabled)": theme.colors.button.danger.hoverBackground,
        ":focus:not(:disabled)": theme.colors.button.danger.hoverBackground,
    },
};

export const Button = React.forwardRef<HTMLButtonElement, IButton.IProps>(
    function Button({ variant = "primary", loading, css = {}, ...props }, ref) {
        const styles = merge(variantStyles[variant], commonStyles, css);

        return (
            <Element
                as="button"
                css={styles}
                ref={ref}
                disabled={props.disabled || loading}
                data-loading={loading}
                {...props}
            >
                {loading ? <AnimatingDots /> : props.children}
            </Element>
        );
    }
);

Button.defaultProps = {
    type: "button",
};

/** Animation dots, we use the styled.span syntax
 *  because keyframes aren't supported in the object syntax
 */
const transition = keyframes({
    "0%": { opacity: 0.6 },
    "50%": { opacity: 1 },
    "100%": { opacity: 0.6 },
});

const Dot = styled.span`
    font-size: 18px;
    animation: ${transition} 1.5s ease-out infinite;
`;

const AnimatingDots = () => (
    <>
        <VisuallyHidden>Loading</VisuallyHidden>
        <span role="presentation">
            <Dot>·</Dot>
            <Dot style={{ animationDelay: "200ms" }}>·</Dot>
            <Dot style={{ animationDelay: "400ms" }}>·</Dot>
        </span>
    </>
);
