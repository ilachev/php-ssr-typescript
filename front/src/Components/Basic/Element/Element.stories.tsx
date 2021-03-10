import { Element } from ".";
import { LayoutDecorator } from "../../../../.storybook/Decorators";

export default {
    title: "Basic/Element",
    component: Element,
    decorators: [LayoutDecorator],
};

export const Basic = () => <Element css={{ color: "pink" }}>content</Element>;

export const Margins = () => (
    <>
        <Element margin={2} css={{ color: "pink" }}>
            2 on the space grid is 2*4px = 8px or 0.5em
        </Element>
        <Element marginX={2} css={{ color: "pink" }}>
            left and right
        </Element>
        <Element marginY={2} css={{ color: "pink" }}>
            top and bottom
        </Element>
        <Element marginBottom={2} css={{ color: "pink" }}>
            prefer margin bottom when you can
        </Element>
    </>
);
