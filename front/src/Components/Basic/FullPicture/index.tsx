// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element } from "@Components/Basic";
import { Picture } from "@Components/Basic/Picture";
import Modal from "react-modal";
import { HeaderActions } from "@Actions";
import { IFullPicture } from "./FullPicture";
// #endregion Local Imports

Modal.setAppElement("#__next");

const customStyles = {
    content: {
        position: "absolute",
        inset: "0px",
        border: "none",
        background: "transparent",
        overflow: "hidden",
        borderRadius: "0px",
        outline: "none",
        padding: "0px",
    },
    overlay: {
        overflow: "transparent",
        zIndex: 1000,
        transition: "opacity .3s cubic-bezier(0,0,.2,1)",
    },
};

export const FullPicture: FunctionComponent<IFullPicture.IProps> = ({
    alt,
    src,
    isOpen,
    setIsOpen,
}) => {
    const handleClose = (e: Event) => {
        const element = e.target as HTMLElement;
        if (element.tagName !== "IMG") {
            setIsOpen(false);
        }
    };

    return (
        <Modal
            isOpen={isOpen}
            onRequestClose={handleClose as any}
            contentLabel="Детальная картинка"
            style={customStyles as any}
        >
            <Element
                css={css({
                    backgroundColor: "rgba(0,0,0,.85)",
                    outline: "none",
                    top: "0",
                    left: "0",
                    right: "0",
                    bottom: "0",
                    zIndex: "1000",
                    width: "100%",
                    height: "100%",
                    touchAction: "none",
                })}
            >
                <Element
                    css={css({
                        position: "absolute",
                        top: "0",
                        right: "0",
                        left: "0",
                        bottom: "0",
                    })}
                    onClick={(e: Event) => handleClose(e)}
                >
                    <Picture
                        alt={alt}
                        src={src}
                        imageCss={{
                            margin: "auto",
                            position: "absolute",
                            top: 0,
                            left: 0,
                            right: 0,
                            bottom: 0,
                            maxWidth: "90vw",
                            touchAction: "none",
                        }}
                    />
                </Element>
                <Element
                    as="div"
                    css={css({
                        background:
                            "url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIj48cGF0aCBkPSJtIDEsMyAxLjI1LC0xLjI1IDcuNSw3LjUgNy41LC03LjUgMS4yNSwxLjI1IC03LjUsNy41IDcuNSw3LjUgLTEuMjUsMS4yNSAtNy41LC03LjUgLTcuNSw3LjUgLTEuMjUsLTEuMjUgNy41LC03LjUgLTcuNSwtNy41IHoiIGZpbGw9IiNGRkYiLz48L3N2Zz4=) no-repeat 50%;",
                        width: "40px",
                        height: "35px",
                        cursor: "pointer",
                        border: "none",
                        opacity: ".7",
                        verticalAlign: "middle",
                        marginLeft: "auto",
                    })}
                    onClick={handleClose}
                />
            </Element>
        </Modal>
    );
};
