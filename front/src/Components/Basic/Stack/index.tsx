// #region Global Imports
import React from "react";
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { IStack } from "./Stack";
import { Element } from "../Element";
// #endregion Local Imports

export const Stack = styled(Element)<IStack.IProps>(
    ({ gap = 0, direction = "horizontal", justify, align, inline }) =>
        css({
            display: inline ? "inline-flex" : "flex",
            flexDirection: direction === "horizontal" ? "row" : "column",
            justifyContent: justify,
            alignItems: align,

            "> *:not(:last-child)": {
                [direction === "horizontal"
                    ? "marginRight"
                    : "marginBottom"]: gap,
            },
        })
);
