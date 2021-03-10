// #region Global Imports
import React from "react";
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled/theme";
import { ISwitch } from "./Switch";
import { Element } from "../Element";
// #endregion Local Imports

const SwitchBackground = styled.div(
    css({
        width: "28px",
        height: "16px",
        backgroundColor: theme.colors.switch.backgroundOff,
        border: "1px solid",
        borderColor: theme.colors.sidebar.background,
        borderRadius: "16px",
        position: "relative",
        transition: "background-color ease",
        transitionDuration: theme.speeds[3],
    })
);

const SwitchToggle = styled.span(
    css({
        width: "12px",
        height: "12px",
        backgroundColor: theme.colors.switch.toggle,
        borderColor: theme.colors.sidebar.background,
        borderRadius: "50%",
        position: "absolute",
        margin: "1px",
        left: 0,
        transition: "left ease",
        transitionDuration: theme.speeds[3],
    })
);

const SwitchInput = styled.input(
    css({
        width: 0,
        opacity: 0,
        position: "absolute",
        left: -100,
    })
);

const SwitchContainer = styled(Element)(
    css({
        "input:checked + [data-component=SwitchBackground]": {
            backgroundColor: theme.colors.switch.backgroundOn,
        },
        "input:checked + [data-component=SwitchBackground] [data-component=SwitchToggle]": {
            left: `${theme.space[3] - 4}px`,
        },
    })
);

export const Switch: React.FC<ISwitch.IProps> = ({
    on,
    defaultOn,
    ...props
}) => (
    <SwitchContainer as="label">
        <SwitchInput
            type="checkbox"
            checked={on}
            defaultChecked={defaultOn}
            {...props}
        />
        <SwitchBackground data-component="SwitchBackground">
            <SwitchToggle data-component="SwitchToggle" />
        </SwitchBackground>
    </SwitchContainer>
);
