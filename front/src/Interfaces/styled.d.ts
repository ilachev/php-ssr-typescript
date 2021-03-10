// #region Global Imports
import "styled-components";
// #endregion Global Imports

declare module "styled-components" {
    export interface DefaultTheme {
        colors: {
            primary: string;
            secondary: string;
            success: string;
            danger: string;
            warning: string;
            info: string;
            light: string;
            dark: string;

            link: string;
            hoverLink: string;
            visitedLink: string;

            button: {
                primary: {
                    background: string;
                    foreground: string;
                    hoverBackground: string;
                };
                link: {
                    background: string;
                    foreground: string;
                    hoverBackground: string;
                };
                secondary: {
                    background: string;
                    foreground: string;
                    hoverBackground: string;
                };
                danger: {
                    background: string;
                    foreground: string;
                    hoverBackground: string;
                };
            };

            background: {
                light: string;
                dark: string;
            };

            input: {
                background: string;
                foreground: string;
                border: string;
                placeholderForeground: string;
                focusBackground: string;
            };
            inputOption: {
                activeBorder: string;
            };
            switch: {
                backgroundOff: string;
                backgroundOn: string;
                toggle: string;
            };
            sidebar: {
                background: string;
            };
            list: {
                foreground: string;
                hoverForeground: string;
                hoverBackground: string;
            };
        };

        speeds: Array;
        space: Array;
        breakpoints: Array;
        fontSizes: Array;
        fontWeights: Array;
        lineHeights: Array;
        letterSpacings: Array;
        borders: Array;
        zIndices: Array;
        radii: Array;
    }
}
