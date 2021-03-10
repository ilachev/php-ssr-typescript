import React from "react";

declare namespace ISelect {
    export interface IProps
        extends React.InputHTMLAttributes<HTMLInputElement>,
            React.SelectHTMLAttributes<HTMLSelectElement> {
        icon?: any;
        placeholder?: any;
        variant?: "default" | "link";
    }
}

export { ISelect };
