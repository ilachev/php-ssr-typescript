export interface PromoResponse {
    id: string;
    name: string;
}

export interface PromoCountResponse {
    promoCount: [
        {
            type: string;
            count: number;
            name: string;
        }
    ];
}

export interface CommentResponse {
    id: string;
    name: string;
}

export interface CommentCountResponse {
    commentsCount: {
        count: number;
    };
}

export interface LeaveCommentResponse {}

export interface CommentsResponse extends Array<CommentResponse> {}

export interface CommentsCountResponse extends CommentCountResponse {}

export interface StoreResponse {
    id: string;
    name: string;
}

export interface StorePageInfoResponse {
    seo: object;
}

export interface StoresResponse extends Array<StoreResponse> {}

export interface PromosResponse extends Array<PromoResponse> {}

export interface PromosCountResponse extends PromoCountResponse {}
