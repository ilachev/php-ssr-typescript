export interface BlogResponse {
    id: string;
    name: string;
}

export interface BlogCommentResponse {
    id: string;
    name: string;
}

export interface BlogCommentCountResponse {
    commentsCount: {
        count: number;
    };
}

export interface BlogLeaveCommentResponse {}

export interface BlogCommentsResponse extends Array<BlogCommentResponse> {}

export interface BlogCommentsCountResponse extends BlogCommentCountResponse {}
