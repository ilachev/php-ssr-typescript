import React from "react";
import { IText } from "@Components/Basic/Text/Text";

declare namespace ILink {
    export interface IProps
        extends React.AnchorHTMLAttributes<HTMLAnchorElement>,
            React.AnchorHTMLAttributes<HTMLSpanElement>,
            IText.IProps,
            ITextProps {
        as?: any;
        to?: string;
    }
}

export { ILink };
