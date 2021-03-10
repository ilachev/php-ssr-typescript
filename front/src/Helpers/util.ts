// #region Global Imports
import deepmerge from "deepmerge";
// #endregion Global Imports

export const isClient = typeof window === "object";

export const isServer = typeof window !== "object";

export const merge = (...objs) =>
    objs.reduce(function mergeAll(merged, currentValue = {}) {
        return deepmerge(merged, currentValue);
    }, {});

export const executeCaptcha = (): Promise<string> => {
    return window.grecaptcha.execute();
};
