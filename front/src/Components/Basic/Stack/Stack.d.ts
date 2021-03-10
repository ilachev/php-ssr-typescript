import React from "react";

declare namespace IStack {
    export interface IProps {
        gap?: number; // theme.space token
        direction?: "horizontal" | "vertical";
        justify?: React.CSSProperties["justifyContent"];
        align?: React.CSSProperties["alignItems"];
        inline?: boolean;
        style?: Object;
    }
}

export { IStack };
