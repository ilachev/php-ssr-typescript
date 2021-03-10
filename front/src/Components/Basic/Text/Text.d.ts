import React from "react";

declare namespace IText {
    export interface IProps extends React.HTMLAttributes<HTMLSpanElement> {
        size?: number;
        align?: string;
        weight?: string;
        fontStyle?: string;
        block?: boolean;
        maxWidth?: number | string;
        variant?: "body" | "muted" | "danger" | "active";
        dateTime?: string;
        cursor?: string;
        textDecoration?: string;
        marginTop?: string;
        padding?: string;
        margin?: string;
        childRef?: any;
    }
}

export { IText };
