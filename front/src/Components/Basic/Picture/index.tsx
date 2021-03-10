// #region Global Imports
import { FunctionComponent } from "react";
import { InView } from "react-intersection-observer";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element } from "@Components/Basic";
import { IPicture } from "./Picture";
// #endregion Local Imports

export const Picture: FunctionComponent<IPicture.IProps> = (props) => {
    return (
        <InView triggerOnce>
            {({ inView, ref }) => (
                <Element
                    ref={ref}
                    as="picture"
                    css={css({ ...props.containerCss })}
                >
                    {inView ? (
                        <Element
                            as="img"
                            src={props.src}
                            alt={props.alt}
                            css={css({ ...props.imageCss })}
                        />
                    ) : null}
                </Element>
            )}
        </InView>
    );
};
