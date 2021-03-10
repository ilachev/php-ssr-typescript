// #region Global Imports
import React from "react";
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled/theme";
import { IListAction } from "./List";
import { Element } from "../Element";
import { Stack } from "../Stack";
// #endregion Local Imports

export const List = styled(Element).attrs((p) => ({
    as: ((p as unknown) as { as: string }).as || "ul",
}))(
    css({
        listStyle: "none",
        paddingLeft: 0,
        margin: 0,
    })
);

export const ListItem = styled(Stack).attrs({
    as: "li",
    align: "center",
})(
    css({
        minHeight: 8,
        paddingX: 2,
        color: theme.colors.list.foreground,
    })
);

export const ListAction = styled(ListItem)<IListAction.IProps>(({ disabled }) =>
    css({
        ':hover, &[aria-selected="true"]': {
            cursor: !disabled ? "pointer" : "disabled",
            color: !disabled ? theme.colors.list.hoverForeground : "inherit",
            backgroundColor: !disabled
                ? theme.colors.list.hoverBackground
                : "inherit",
        },
        ":focus-within": {
            color: !disabled ? theme.colors.list.hoverForeground : "inherit",
            backgroundColor: !disabled
                ? theme.colors.list.hoverBackground
                : "inherit",
        },
    })
);
