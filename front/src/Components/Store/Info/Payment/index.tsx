// #region Global Imports
import { FunctionComponent } from "react";
import { withTranslation } from "@Server/i18n";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element, Text } from "@Components/Basic";
// #endregion Local Imports

// #region Interface Imports
import { IPayment } from "./Payment";
// #endregion Interface Imports

const Component: FunctionComponent<IPayment.IProps> = ({
    payment,
}): JSX.Element => {
    return (
        <Element
            css={css({
                display: "block",
                width: "100%",
            })}
        >
            <Element
                css={css({
                    display: "flex",
                    flexFlow: "column",
                    width: "auto",
                    border: "1px solid #e0e0e0",
                    padding: "18px",
                    borderRadius: "5px",
                    marginBottom: "10px",
                    backgroundColor: "#fff",
                })}
            >
                <Text as="h2" size={2} marginTop="0px">
                    <Text size={3}>💸 </Text>
                    Оплата
                </Text>
                <Text
                    as="div"
                    size={1}
                    margin="0px"
                    dangerouslySetInnerHTML={{ __html: payment || "" }}
                />
            </Element>
        </Element>
    );
};

const Payment = withTranslation("common")(Component);

export { Payment };
