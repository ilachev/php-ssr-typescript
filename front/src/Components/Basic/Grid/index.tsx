// #region Global Imports
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { IGrid, IColumn } from "./Grid";
import { Element } from "../Element";
// #endregion Local Imports

const fontSize = 1; // rem = 16px
const lineHeight = fontSize * 1.5;

export const Grid = styled(Element)<IGrid.IProps>(
    ({ columnGap, rowGap, templateColumns }) =>
        css({
            display: "grid",
            gridTemplateColumns:
                typeof templateColumns !== "undefined"
                    ? `repeat(${templateColumns}, 1fr)`
                    : "repeat(12, 1fr)",
            gridColumnGap:
                typeof columnGap !== "undefined" ? columnGap : "2rem",
            gridRowGap:
                typeof rowGap !== "undefined" ? rowGap : `${lineHeight}rem`,
            alignItems: "center",
        })
);

// todo: end and span cant be together
// valid combinations are
// start | start + end | start + span | span
// span + end is also possible but not implemented here
export const Column = styled(Element)<IColumn.IProps>(
    ({ start, end, span, alignSelf, justifySelf }) => {
        const styles: {
            gridColumnStart?: number | Array<number | string>;
            gridColumnEnd?: number | string | Array<number> | Array<string>;
            display?: string | Array<string>;
            alignSelf?: string;
            justifySelf?: string;
        } = {};

        if (Array.isArray(start)) styles.gridColumnStart = start.map((s) => s);
        else if (start) styles.gridColumnStart = start;

        if (Array.isArray(end)) styles.gridColumnEnd = end.map((s) => s + 1);
        else if (end) styles.gridColumnEnd = end + 1;

        if (Array.isArray(span))
            styles.gridColumnEnd = span.map((s) => `span  ${s}`);
        else if (span) styles.gridColumnEnd = `span ${span}`;

        // not sure if span=0 is a good idea, we'll find out
        if (Array.isArray(span)) {
            styles.display = span.map((s) => (s === 0 ? "none" : "inherit"));
        } else if (span === 0) styles.display = "none";

        if (typeof alignSelf !== "undefined") styles.alignSelf = alignSelf;
        if (typeof justifySelf !== "undefined")
            styles.justifySelf = justifySelf;

        return css(styles);
    }
);

export const Row = styled(Grid).attrs({ span: 12 })(
    css({
        gridColumnEnd: "span 12",
    })
);
