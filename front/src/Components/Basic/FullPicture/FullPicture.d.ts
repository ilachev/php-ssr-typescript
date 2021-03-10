import { Dispatch, SetStateAction } from "react";

declare namespace IFullPicture {
    export interface IProps {
        alt: string;
        src: string;
        isOpen: boolean;
        setIsOpen: Dispatch<SetStateAction<any>>;
    }
}

export { IFullPicture };
