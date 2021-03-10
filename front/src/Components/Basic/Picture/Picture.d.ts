import * as React from "react";
import { InterpolationWithTheme } from "@emotion/core";

declare namespace IPicture {
    export interface IProps {
        imageCss?: object;
        containerCss?: object;
        as?: string;
        className?: string;
        alt: string;
        src: string;
        onClick?: Function;
        ref?: React.RefObject<any> | ((node?: Element | null) => void);
    }
}

export { IPicture };
