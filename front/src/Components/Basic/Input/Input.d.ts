import React from "react";
import { IElement } from "../Element/Element";

declare namespace IInput {
    export interface IProps
        extends React.InputHTMLAttributes<HTMLInputElement>,
            IElement.IProps {}
}

export { IInput };
