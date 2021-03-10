// #region Interface Imports
import {
    IHomePage,
    IHeader,
    IStorePage,
    IConfirmPage,
    IResetPage,
    IBlogPage,
    ICategoryPage,
} from "@Interfaces";
import { IStateProps } from "@Reducers/Info";
// #endregion Interface Imports

export interface IStore {
    Header: IHeader.IStateProps;
    Home: IHomePage.IStateProps;
    Store: IStorePage.IStateProps;
    Info: IStateProps;
    Confirm: IConfirmPage.IStateProps;
    Reset: IResetPage.IStateProps;
    Blog: IBlogPage.IStateProps;
    Category: ICategoryPage.IStateProps;
}
