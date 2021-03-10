import React from "react";

declare namespace ICheckbox {
    export interface IProps
        extends React.InputHTMLAttributes<HTMLInputElement> {
        checked?: boolean;
        label?: string;
        id?: string;
    }
}

export { ICheckbox };
