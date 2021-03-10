// #region Global Imports
import { combineReducers } from "redux";
// #endregion Global Imports

// #region Local Imports
import { HomeReducer } from "./Home";
import { HeaderReducer } from "./Header";
import { StoreReducer } from "./Store";
import { InfoReducer } from "./Info";
import { ConfirmReducer } from "./Confirm";
import { ResetReducer } from "./Reset";
import { BlogReducer } from "./Blog";
import { CategoryReducer } from "./Category";
// #endregion Local Imports

const combinedReducer = combineReducers({
    Home: HomeReducer,
    Header: HeaderReducer,
    Store: StoreReducer,
    Info: InfoReducer,
    Confirm: ConfirmReducer,
    Reset: ResetReducer,
    Blog: BlogReducer,
    Category: CategoryReducer,
});

export default combinedReducer;
