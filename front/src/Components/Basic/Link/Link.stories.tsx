import React from "react";
import { Link } from ".";

export default {
    title: "Basic/Link",
    component: Link,
};

export const Basic = () => (
    <Link href="https://codesandbox.io">Plan old boring text</Link>
);

export const Muted = () => (
    <Link variant="muted" href="https://codesandbox.io">
        muted link
    </Link>
);
