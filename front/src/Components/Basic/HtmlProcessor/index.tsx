import { FunctionComponent, useState } from "react";
import {
    attributesToProps,
    domToReact,
    HTMLReactParserOptions,
    htmlToDOM,
} from "html-react-parser";
import { WithTranslation } from "next-i18next";
import { Element as ElementType } from "domhandler/lib/node";

import { FullPicture } from "@Components/Basic/FullPicture";
import { Element } from "@Components/Basic";
import { Picture } from "@Components/Basic/Picture";

interface IProps {
    html: string;
    previewWidth: number;
}

const HtmlProcessor: FunctionComponent<IProps> = ({
    html,
    previewWidth,
}): any => {
    const reactParserOptions: HTMLReactParserOptions = {
        replace: (domNode) => {
            if (domNode instanceof ElementType) {
                if (domNode.tagName === "img") {
                    const props = attributesToProps(domNode.attribs);

                    const [isOpen, setIsOpen] = useState(false);

                    return (
                        <>
                            <FullPicture
                                isOpen={isOpen}
                                setIsOpen={setIsOpen}
                                alt={props.alt}
                                src={props.src}
                            />
                            <Element as="span" onClick={() => setIsOpen(true)}>
                                <Picture
                                    alt={props.alt}
                                    src={`${props.src}?w=${previewWidth}`}
                                    imageCss={{
                                        maxWidth: "100%",
                                        objectFit: "contain",
                                        cursor: "pointer",
                                    }}
                                />
                            </Element>
                        </>
                    );
                }
            }
        },
    };

    return domToReact(htmlToDOM(html), reactParserOptions);
};

export { HtmlProcessor };
