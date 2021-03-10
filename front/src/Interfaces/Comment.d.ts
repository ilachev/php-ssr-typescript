export interface Comment {
    id: string;
    text: string;
    level: number;
    parent_id: string | null;
    author_id: string;
    author_name: string;
    avatar: string;
    date: string;
    date_atom: string;
    user_role: string | null;
    children: Array<Comment>;
}
