import { ButtonHTMLAttributes } from "react";
import { IElement } from "../Element/Element";

declare namespace IButton {
    export interface IProps
        extends ButtonHTMLAttributes<HTMLButtonElement>,
            IElement.IProps {
        variant?: "primary" | "secondary" | "link" | "danger";
        loading?: boolean;
        href?: string;
        to?: string;
        as?: any;
        target?: any;
        ref?: any;
    }
}

export { IButton };
