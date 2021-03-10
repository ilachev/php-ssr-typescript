export interface CategoryResponse {
    id: string;
    name: string;
}

export interface CategoriesResponse extends Array<CategoryResponse> {}
