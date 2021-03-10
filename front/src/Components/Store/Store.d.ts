// #region Global Imports
import { WithTranslation } from "next-i18next";
// #endregion Global Imports

// #region Local Imports
import { Comment, Pagination, Violation } from "@Interfaces";
// #endregion Local Imports

declare namespace IStorePage {
    export interface IProps extends WithTranslation {
        store: {
            description: string;
            info: {
                contacts?: string;
                delivery?: string;
                payment?: string;
                detail?: string;
            };
            name: string;
            slug: string;
            logo?: {
                name: string;
                url: string;
            };
        };
        h1: string;
        seoDescription: string;
    }

    export interface IState {}

    export interface IStateProps {
        activePromoType: string;
        isPromoCodeClicked: boolean;
        isBaseCommentFormActive: boolean;
        activeCommentId: string;
        store: {
            id: string;
            description: string;
            name: string;
            slug: string;
            info: {
                contacts?: string;
                delivery?: string;
                payment?: string;
                detail?: string;
            };
            logo?: {
                name: string;
                url: string;
            };
        };
        promos: {
            items: [
                {
                    id: number;
                    name: string;
                    status: string;
                    type: string;
                    discount?: number;
                    discount_unit?: string;
                    referral: string;
                }
            ];
            pagination: Pagination;
        };
        old_promos: {
            items: [
                {
                    id: number;
                    name: string;
                    status: string;
                    type: string;
                    discount?: number;
                    discount_unit?: string;
                    referral: string;
                }
            ];
            pagination: Pagination;
        };
        promoCount: {
            count: [
                {
                    type: string;
                    count: number;
                    name: string;
                }
            ];
        };
        comments: {
            items: Array<Comment>;
            pagination: Pagination;
        };
        commentsCount: {
            count: number;
        };
        leaveComment: {
            data: {
                text: string;
            };
            errors: {
                violations: Array<Violation>;
            };
            status?: string;
        };
    }

    module Actions {
        export interface IMapPayload {
            comments: {
                items: Array<Comment>;
                pagination: Pagination;
            };
        }
        export interface IMapResponse {}
    }
}

export { IStorePage };
