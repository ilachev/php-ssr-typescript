// #region Global Imports
import React from "react";
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled/theme";
import { IText } from "./Text";
import { Element } from "../Element";
// #endregion Local Imports

const variants = {
    body: "inherit",
    muted: theme.colors.button.secondary.background,
    danger: theme.colors.button.danger.background,
    active: theme.colors.button.primary.background,
};

const overflowStyles = {
    overflow: "hidden",
    textOverflow: "ellipsis",
    whiteSpace: "nowrap",
};

export const Text = styled(Element).attrs((p) => ({
    as: ((p as unknown) as { as: string }).as || "span",
}))<IText.IProps>(
    ({
        size,
        fontStyle,
        align,
        weight,
        block,
        variant = "body",
        maxWidth,
        cursor,
        textDecoration,
        marginTop,
        padding,
        margin,
        ...props
    }) =>
        css({
            fontSize: size || "inherit", // from theme.fontSizes
            textAlign: align || "left",
            fontWeight: weight || null, // from theme.fontWeights
            fontStyle: fontStyle || null, // from theme.fontWeights
            display: block || maxWidth ? "block" : "inline",
            color: variants[variant],
            cursor: cursor || "inherit",
            textDecoration: textDecoration || "none",
            marginTop: marginTop || null,
            margin: margin || null,
            padding: padding || null,
            maxWidth,
            ...(maxWidth ? overflowStyles : {}),
            "> *": {
                marginTop: marginTop || null,
                margin: margin || null,
            },
        })
);
