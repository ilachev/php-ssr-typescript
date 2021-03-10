// #region Global Imports
import { FunctionComponent } from "react";
// #endregion Global Imports

// #region Local Imports
import { IIcon } from "./Icon";
import * as icons from "./icons";
// #endregion Local Imports

export const Icon: FunctionComponent<IIcon.IProps> = ({
    name = "notFound",
    size = 16,
    color = "inherit",
    ...props
}) => {
    const SVG = icons[name];

    return <SVG width={size} height={size} color={color} {...props} />;
};
