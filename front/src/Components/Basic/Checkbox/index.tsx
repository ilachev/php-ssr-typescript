// #region Global Imports
import React from "react";
import styled from "styled-components";
import css from "@styled-system/css";
import { useId } from "@reach/auto-id";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled/theme";
import { ICheckbox } from "./Checkbox";
import { Element } from "../Element";
import { Text } from "../Text";
// #endregion Local Imports

export const CheckboxElement = styled.input(
    css({
        left: 0,
        opacity: 0,
        position: "absolute",
        top: 0,
        height: 4,
        width: 4,

        "&:checked + label::after": {
            opacity: 1,
        },

        "&:checked + label::before": {
            backgroundColor: theme.colors.button.link.background,
        },
    })
);

const Label = styled(Text)(
    css({
        display: "block",
        paddingLeft: "16px",
        "&::before": {
            content: "''",
            height: "16px",
            left: 0,
            position: "absolute",
            top: 0,
            width: "16px",
            borderRadius: "small",
            backgroundColor: theme.colors.input.background,
            color: theme.colors.input.foreground,
            transition: "all ease-in",
            transitionDuration: theme.speeds[2],
        },
        "&::after": {
            content: "''",
            borderLeft: 0,
            borderTop: 0,
            height: "16px",
            left: "2px",
            opacity: 0,
            position: "absolute",
            top: 1,
            backgroundImage: `url('data:image/svg+xml,%3Csvg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath fill-rule="evenodd" clip-rule="evenodd" d="M5.0442 5.99535L10.2229 0.444443L11.3332 1.70347L5.0442 8.44444L0.666504 3.75212L1.77676 2.49309L5.0442 5.99535Z" fill="${theme.colors.input.foreground.replace(
                "#",
                "%23"
            )}"/%3E%3C/svg%3E%0A')`,
            backgroundRepeat: "no-repeat",
            width: "16px",
            transition: "all ease-in",
            transitionDuration: theme.speeds[2],
        },
    })
);

export const Checkbox: React.FunctionComponent<ICheckbox.IProps> = ({
    checked,
    id,
    label,
    ...props
}) => {
    const inputId = useId(id);
    return (
        <Element style={{ position: "relative" }}>
            <CheckboxElement
                checked={checked}
                id={inputId}
                name={inputId}
                type="checkbox"
                {...props}
            />
            <Label as="label" htmlFor={inputId}>
                {label}
            </Label>
        </Element>
    );
};
