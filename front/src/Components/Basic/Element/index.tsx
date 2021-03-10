// #region Global Imports
import { FunctionComponent } from "react";
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { IElement } from "./Element";
// #endregion Local Imports

// 0 is an allowed value, even though it's falsy
const Container = styled.div<IElement.IProps>((props: IElement.IProps) =>
    css({
        boxSizing: "border-box",
        margin: nullCheck(props.margin),
        marginX: nullCheck(props.marginX),
        marginY: nullCheck(props.marginY),
        marginBottom: nullCheck(props.marginBottom),
        marginTop: nullCheck(props.marginTop),
        marginLeft: nullCheck(props.marginLeft),
        marginRight: nullCheck(props.marginRight),
        padding: nullCheck(props.padding),
        paddingX: nullCheck(props.paddingX),
        paddingY: nullCheck(props.paddingY),
        paddingBottom: nullCheck(props.paddingBottom),
        paddingTop: nullCheck(props.paddingTop),
        paddingLeft: nullCheck(props.paddingLeft),
        paddingRight: nullCheck(props.paddingRight),
    })
);

const nullCheck = (value: any) => {
    if (typeof value !== "undefined") return value;
    return null;
};

export const Element: FunctionComponent<IElement.IProps> = (props) => {
    // @ts-ignore
    return (
        // @ts-ignore
        <Container ref={props.childRef} dateTime={props.dateTime} {...props} />
    );
};
