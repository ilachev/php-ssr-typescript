declare namespace IGrid {
    export interface IProps {
        columnGap?: number;
        rowGap?: number;
        templateColumns?: number;
    }
}

declare namespace IColumn {
    export interface IProps {
        start?: number | Array<number>;
        end?: number | Array<number>;
        span?: number | Array<number>;
        alignSelf?:
            | "auto"
            | "normal"
            | "start"
            | "end"
            | "center"
            | "stretch"
            | "baseline"
            | "first baseline"
            | "last baseline";
        justifySelf?:
            | "auto"
            | "normal"
            | "start"
            | "end"
            | "center"
            | "stretch"
            | "baseline"
            | "first baseline"
            | "last baseline";
    }
}

export { IGrid, IColumn };
