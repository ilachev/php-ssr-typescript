import { useCallback, useEffect, useState } from "react";
import copy from "copy-to-clipboard";

const useCopyToClipboard = (resetInterval: number | null = null) => {
    const [isCopied, setCopied] = useState(false);

    const handleCopy = useCallback((text: number | string) => {
        if (typeof text === "string" || true) {
            copy(text.toString());
            setCopied(true);
        } else {
            setCopied(false);
        }
    }, []);

    useEffect(() => {
        let timeout;
        if (isCopied && resetInterval) {
            timeout = setTimeout(() => setCopied(false), resetInterval);
        }
        return () => {
            clearTimeout(timeout);
        };
    }, [isCopied, resetInterval]);

    return [isCopied, handleCopy];
};

export { useCopyToClipboard };
