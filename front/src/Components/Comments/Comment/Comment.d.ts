// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

// #region Global Imports
import { Comment } from "@Interfaces";
// #endregion Global Imports

declare namespace IComment {
    export interface IProps extends WithTranslation {
        comment: Comment;
    }

    export interface IState {}

    export interface IStateProps {}

    module Actions {
        export interface IMapPayload {}
        export interface IMapResponse {}
    }
}

export { IComment };
