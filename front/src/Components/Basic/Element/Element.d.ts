declare namespace IElement {
    export interface IProps {
        margin?: number;
        marginX?: number;
        marginY?: number;
        marginBottom?: number;
        marginTop?: number; // prefer margin bottom to top
        marginLeft?: number;
        marginRight?: number;
        padding?: number;
        paddingX?: number;
        paddingY?: number;
        paddingBottom?: number;
        paddingTop?: number;
        paddingLeft?: number;
        paddingRight?: number;
        rows?: number;
        style?: Object;
        as?: string;
        className?: string;
        alt?: string;
        src?: string;
        onClick?: any;
        onSubmit?: any;
        onFocus?: any;
        onChange?: any;
        ref?: any;
        childRef?: any;
        htmlFor?: any;
        dangerouslySetInnerHTML?: object;
        required?: boolean;
        value?: any;
        dateTime?: any;
        placeholder?: string;
    }
}

export { IElement };
