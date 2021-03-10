// #region Global Imports
import React from "react";
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled/theme";
import { IInput } from "./Input";
import { Element } from "../Element";
// #endregion Local Imports

const placeholderStyles = {
    color: theme.colors.input.placeholderForeground,
    fontSize: 1,
};

export const Input = styled(Element).attrs((p) => ({
    as: ((p as unknown) as { as: string }).as || "input",
}))<IInput.IProps>(
    css({
        height: "40px",
        width: "100%",
        paddingX: 2,
        fontSize: 3,
        lineHeight: 1, // trust the height
        fontFamily: "'Open Sans', sans-serif",
        borderRadius: "5px",
        border: "1px solid",
        backgroundColor: theme.colors.input.background,
        borderColor: theme.colors.input.border,
        color: theme.colors.input.foreground,
        "::-webkit-input-placeholder": placeholderStyles,
        "::-ms-input-placeholder": placeholderStyles,
        "::placeholder": placeholderStyles,
        transition: "all ease",
        transitionDuration: theme.speeds[2],

        ":focus": {
            backgroundColor: theme.colors.input.focusBackground,
            borderColor: theme.colors.inputOption.activeBorder,
            outline: "none",
        },
        ":disabled": {
            opacity: 0.4,
            borderColor: theme.colors.input.border, // (default border)
        },
    })
);
