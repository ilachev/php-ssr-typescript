// #region Global Imports
import { FunctionComponent } from "react";
import { withTranslation } from "@Server/i18n";
import css from "@styled-system/css";
import { useDispatch } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { Element } from "@Components/Basic";
import { useCopyToClipboard } from "@Helpers/useCopyToClipboard";
// #endregion Local Imports

// #region Interface Imports
import { StoreActions } from "@Actions";
import { IPromoCodeButton } from "./PromoCodeButton";
// #endregion Interface Imports

const Component: FunctionComponent<IPromoCodeButton.IProps> = ({
    code,
    referral,
    modalIsOpen,
}): JSX.Element => {
    const [isCopied, handleCopy] = useCopyToClipboard(500);
    const dispatch = useDispatch();

    const handleButtonClick = (code, e: Event) => {
        e.preventDefault();
        // @ts-ignore
        handleCopy(code);
        dispatch(
            StoreActions.Map({
                isPromoCodeClicked: true,
            })
        );
        if (!modalIsOpen) {
            window.open(window.location.href, "_blank");
            window.location.assign(referral);
        }
    };

    if (undefined === code || code === null) {
        return <></>;
    }

    return (
        <Element
            css={css({
                border: "1px solid #bdbdbd",
                cursor: "pointer",
                display: "inline-block",
                padding: "7px 29px",
                minWidth: "190px",
                width: "190px",
                height: "40px",
                borderRadius: "5px",
                marginBottom: "50px",
                backgroundColor: "#f5f5f5",
                zIndex: 1,
            })}
            onClick={(e: Event) => handleButtonClick(code, e)}
        >
            {!isCopied ? (
                <Element
                    css={css({
                        color: "#212121",
                        width: "100%",
                        border: "none",
                        height: "100%",
                        resize: "none",
                        outline: "none",
                        overflow: "hidden",
                        fontSize: "16px",
                        lineHeight: "24px",
                        background: "transparent",
                        textAlign: "center",
                        fontWeight: 600,
                    })}
                >
                    {code}
                </Element>
            ) : (
                <Element
                    css={css({
                        color: "#212121",
                        width: "100%",
                        border: "none",
                        height: "100%",
                        resize: "none",
                        outline: "none",
                        overflow: "hidden",
                        fontSize: "16px",
                        lineHeight: "24px",
                        background: "transparent",
                        textAlign: "center",
                        fontWeight: 600,
                    })}
                >
                    Скопировано!
                </Element>
            )}
        </Element>
    );
};

const PromoCodeButton = withTranslation("common")(Component);

export { PromoCodeButton };
