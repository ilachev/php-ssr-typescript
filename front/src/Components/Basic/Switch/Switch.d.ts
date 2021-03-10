import React from "react";

declare namespace ISwitch {
    export interface IProps {
        id?: string;
        on?: boolean;
        defaultOn?: boolean;
        onChange?: (event: React.ChangeEvent<HTMLInputElement>) => void;
    }
}

export { ISwitch };
