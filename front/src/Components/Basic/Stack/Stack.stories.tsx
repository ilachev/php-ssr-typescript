import { Stack } from ".";
import { LayoutDecorator } from "../../../../.storybook/Decorators";

export default {
    title: "Basic/Stack",
    component: Stack,
    decorators: [LayoutDecorator],
};

// replace the text inside with Text variants when available
export const Defaults = () => (
    <Stack style={{ height: 100 }}>
        <div />
        <div />
    </Stack>
);

export const WithGap = () => (
    <Stack gap={4} style={{ height: 100 }}>
        <div />
        <div>spacing token as gap</div>
        <div />
    </Stack>
);

export const Justify = () => (
    <Stack justify="space-around" style={{ height: 100 }}>
        <div />
        <div />
    </Stack>
);

export const Align = () => (
    <Stack align="center" style={{ height: 100 }}>
        <div />
        <div />
    </Stack>
);
