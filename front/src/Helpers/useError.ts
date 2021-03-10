import { useEffect, useState } from "react";
import { Violation } from "@Interfaces";

const useError = (propertyPath: string, violations: Array<Violation>) => {
    const [isError, setIsError] = useState(false);
    const [title, setTitle] = useState("");

    useEffect(() => {
        setIsError(false);
        setTitle("");
        violations.map((elem: Violation) => {
            if (propertyPath === elem.propertyPath) {
                setIsError(true);
                setTitle(elem.title);
            }
        });
    }, [propertyPath, violations]);

    return [isError, title];
};

export { useError };
