export interface Post {
    id: string;
    name: string;
    date: string;
    comments: {
        count: number;
        info: string;
    };
    date_atom: string;
    logo: {
        name: string;
        url: string;
    };
    description: string;
    slug: string;
    category: {
        slug: string;
        name: string;
    };
    author: {
        name: string;
        avatar: string;
    };
}
