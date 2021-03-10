// #region Global Imports
import { FunctionComponent, useEffect, useState } from "react";
import css from "@styled-system/css";
import useResizeObserver from "use-resize-observer";
// #endregion Global Imports

// #region Local Imports
import { Element, Icon, HtmlProcessor } from "@Components/Basic";
import { withTranslation } from "@Server/i18n";
// #endregion Local Imports

// #region Interface Imports
import { ICss } from "@Interfaces";
import { IDetail } from "./Detail";
// #endregion Interface Imports

const Component: FunctionComponent<IDetail.IProps> = ({
    detail,
}): JSX.Element => {
    const { ref, height = 1 } = useResizeObserver<HTMLDivElement>();
    const [expanded, setExpanded] = useState(true);
    const [isClicked, setIsClicked] = useState(false);

    useEffect(() => {
        if (!isClicked && height > 125) {
            setExpanded(false);
        }
    }, [expanded, isClicked, height]);

    const handleExpandDescription = () => {
        setExpanded(true);
        setIsClicked(true);
    };

    const descriptionContainerCss: ICss = {
        display: "block",
        width: "100%",
        marginBottom: ["30px", null, null, null, "0px"],
        padding: "18px",
        border: "1px solid #e0e0e0",
        borderRadius: "5px",
        backgroundColor: "#fff",
        fontSize: "14px",
        marginTop: "15px",
    };
    let descriptionInnerCss: ICss = {
        display: "flex",
        flexFlow: "column",
        width: "auto",
        borderRadius: "5px",
    };
    let descriptionCss: ICss = {};

    if (!expanded) {
        descriptionInnerCss = {
            ...descriptionInnerCss,
            position: "relative",
            transition: "1s",
            "::after": {
                left: "0px",
                right: "0px",
                bottom: "0px",
                height: "130px",
                content: '""',
                position: "absolute",
                background: "linear-gradient(rgba(255, 255, 255, .2), #ffffff)",
            },
        };
        descriptionCss = {
            ...descriptionCss,
            overflow: "hidden",
            maxHeight: "350px",
            transition: "1s",
        };
    }

    return (
        <Element
            childRef={ref}
            css={css({
                ...descriptionContainerCss,
            })}
        >
            <Element
                css={css({
                    ...descriptionInnerCss,
                })}
            >
                {!expanded ? (
                    <Element
                        css={css({
                            fontSize: "14px",
                            fontWeight: 600,
                            lineHeight: "16px",
                            left: "0px",
                            color: "#424242",
                            width: "100%",
                            bottom: "0px",
                            display: "flex",
                            zIndex: 10,
                            position: "absolute",
                            paddingTop: "50px",
                            paddingBottom: "8px",
                            justifyContent: "center",
                            cursor: "pointer",
                        })}
                        onClick={() => handleExpandDescription()}
                    >
                        Подробнее
                        <Element
                            css={css({
                                display: "flex",
                            })}
                        >
                            <Icon name="arrowDown" />
                        </Element>
                    </Element>
                ) : null}

                <Element
                    css={css({
                        ...descriptionCss,
                    })}
                >
                    <HtmlProcessor html={detail} previewWidth={822} />
                </Element>
            </Element>
        </Element>
    );
};

const Detail = withTranslation("common")(Component);

export { Detail };
