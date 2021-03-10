import { AppConsts } from "@Definitions";
import createLocalStorageStateHook from "./createLocalStorageStateHook";

export default createLocalStorageStateHook(
    AppConsts.Auth.Information,
    undefined
);
