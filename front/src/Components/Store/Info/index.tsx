// #region Global Imports
import { FunctionComponent } from "react";
import { withTranslation } from "@Server/i18n";
// #endregion Global Imports

// #region Local Imports
import { PreviewDescription } from "@Components/Store/StoreSidebar/PreviewDescription";
import { Contacts } from "./Contacts";
import { Payment } from "./Payment";
import { Delivery } from "./Delivery";
// #endregion Local Imports

// #region Interface Imports
import { IInfo } from "./Info";

// #endregion Interface Imports

const Component: FunctionComponent<IInfo.IProps> = ({
    description,
    info,
}): JSX.Element => {
    return (
        <>
            {description !== null ? (
                <PreviewDescription description={description} />
            ) : null}
            {info.contacts !== null ? (
                <Contacts contacts={info.contacts} />
            ) : null}
            {info.payment !== null ? <Payment payment={info.payment} /> : null}
            {info.delivery !== null ? (
                <Delivery delivery={info.delivery} />
            ) : null}
        </>
    );
};

const Info = withTranslation("common")(Component);

export { Info };
