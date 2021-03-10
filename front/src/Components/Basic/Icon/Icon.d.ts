import React from "react";
import { IElement } from "../Element/Element";
import * as icons from "./icons";

type IconNames = keyof typeof icons;

declare namespace IIcon {
    export interface IProps
        extends React.SVGAttributes<SVGElement>,
            IElement.IProps {
        /** name of the icon */
        name: IconNames;
        /** title for accessibility */
        title?: string;
        /** Size of the icon, the button is set to 26x26 */
        size?: number;
        /** icon color */
        color?: string;
    }
}

export { IIcon };
