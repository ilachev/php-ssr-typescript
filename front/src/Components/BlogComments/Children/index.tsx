// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Element } from "@Components/Basic";
// #endregion Local Imports

// #region Interface Imports
import { IChildren } from "./Children";
// #endregion Interface Imports

const Component: FunctionComponent<IChildren.IProps> = ({
    children,
}): JSX.Element => {
    return (
        <Element
            css={css({
                paddingLeft: ["5px", "10px", "20px"],
            })}
        >
            <Element>{children}</Element>
        </Element>
    );
};

const Children = withTranslation("common")(Component);

export { Children };
