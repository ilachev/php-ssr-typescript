// #region Global Imports
import { WithTranslation } from "next-i18next";
import { StoreModel } from "@Services/API/Store/Store";
import { AuthInfo } from "@Interfaces/AuthInfo";
// #endregion Global Imports

declare namespace IIStorePage {
    export interface IProps extends WithTranslation {}

    export interface InitialProps {
        namespacesRequired: string[];
    }

    export interface IStateProps {
        store: {
            id: string;
            name: string;
        };
    }

    namespace Actions {
        export interface IMapPayload {}

        export interface IMapResponse {}

        export interface IGetStorePayload extends StoreModel.GetStorePayload {
            params: {};
        }

        export interface IGetStoreResponse
            extends StoreModel.GetStoreResponse {}

        export interface IGetStorePageInfoPayload
            extends StoreModel.GetStorePageInfoPayload {
            params: {};
        }

        export interface IGetStorePageInfoResponse
            extends StoreModel.GetStorePageInfoResponse {}

        export interface IGetPromosPayload extends StoreModel.GetPromosPayload {
            params: {};
        }

        export interface IGetPromosResponse
            extends StoreModel.GetPromosResponse {}

        export interface IGetPromosCountPayload
            extends StoreModel.GetPromosCountPayload {
            params: {};
        }

        export interface IGetPromosCountResponse
            extends StoreModel.GetPromosCountResponse {}

        export interface IGetCommentsPayload
            extends StoreModel.GetCommentsPayload {
            params: {};
            authInfo?: AuthInfo;
        }

        export interface IGetCommentsResponse
            extends StoreModel.GetCommentsResponse {}

        export interface IGetCommentsCountPayload
            extends StoreModel.GetCommentsCountPayload {
            params: {};
        }

        export interface IGetCommentsCountResponse
            extends StoreModel.GetCommentsCountResponse {}

        export interface IPostLeaveCommentPayload
            extends StoreModel.PostLeaveCommentPayload {}

        export interface IPostLeaveCommentResponse
            extends StoreModel.PostLeaveCommentResponse {}
    }
}

export { IIStorePage };
