// #region Global Imports
import { FunctionComponent, useState, useEffect } from "react";
import useResizeObserver from "use-resize-observer";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element, Icon, Text } from "@Components/Basic";
// #endregion Local Imports

// #region Interface Imports
import { withTranslation } from "@Server/i18n";
import { ICss } from "@Interfaces";
import { IMobilePreviewDescription } from "./MobilePreviewDescription";
// #endregion Interface Imports

const Component: FunctionComponent<IMobilePreviewDescription.IProps> = ({
    description,
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
        marginBottom: "10px",
    };
    let descriptionInnerCss: ICss = {
        display: "flex",
        flexFlow: "column",
        width: "auto",
        border: "1px solid #e0e0e0",
        padding: "18px",
        borderRadius: "5px",
    };
    let descriptionCss: ICss = {
        fontSize: "14px",
        lineHeight: "16px",
        marginTop: "0px",
        color: "#757575",
    };

    if (!expanded) {
        descriptionInnerCss = {
            ...descriptionInnerCss,
            position: "relative",
            transition: "1s",
            "::after": {
                left: "0px",
                right: "0px",
                bottom: "0px",
                height: "90px",
                content: '""',
                position: "absolute",
                background: "linear-gradient(rgba(255, 255, 255, 0), #ffffff)",
            },
        };
        descriptionCss = {
            ...descriptionCss,
            overflow: "scroll",
            maxHeight: "70px",
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
                <Text as="h2" size={1}>
                    Описание
                </Text>

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
                            zIndex: 1,
                            position: "absolute",
                            paddingTop: "50px",
                            paddingBottom: "8px",
                            justifyContent: "center",
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
                    dangerouslySetInnerHTML={{ __html: description }}
                    css={css({
                        ...descriptionCss,
                    })}
                />
            </Element>
        </Element>
    );
};

const MobilePreviewDescription = withTranslation("common")(Component);

export { MobilePreviewDescription };
