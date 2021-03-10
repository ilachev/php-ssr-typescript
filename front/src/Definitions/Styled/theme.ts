// #region Global Imports
import { DefaultTheme } from "styled-components";
// #endregion Global Imports

const theme: DefaultTheme = {
    colors: {
        primary: "#007bff",
        secondary: "#6c757d",
        success: "#28a745",
        danger: "#dc3545",
        warning: "#ffc107",
        info: "#17a2b8",
        light: "#f8f9fa",
        dark: "#343a40",

        background: {
            light: "#ffffff",
            dark: "#adadad",
        },

        link: "#000000",
        hoverLink: "#006efe",
        visitedLink: "#000000",

        button: {
            primary: {
                background: "#007acc",
                foreground: "#ffffff",
                hoverBackground: "#0062a3",
            },
            link: {
                background: "transparent",
                foreground: "#000000",
                hoverBackground: "#000000",
            },
            secondary: {
                background: "#6c757d",
                foreground: "#ffffff",
                hoverBackground: "#6c757d",
            },
            danger: {
                background: "#dc3545",
                foreground: "#ffffff",
                hoverBackground: "#dc3545",
            },
        },

        input: {
            background: "#f5f5f5",
            foreground: "#6c6c6c",
            border: "#f5f5f5",
            placeholderForeground: "#adadad",
            focusBackground: "#ffffff",
        },
        inputOption: {
            activeBorder: "#6c757d",
        },
        switch: {
            backgroundOff: "#ffffff",
            backgroundOn: "#007acc",
            toggle: "#ffffff",
        },
        sidebar: {
            background: "#adadad",
        },
        list: {
            foreground: "#000000",
            hoverForeground: "#adadad",
            hoverBackground: "#f3f3f3",
        },
    },

    speeds: [0, "75ms", "100ms", "150ms", "200ms", "300ms", "500ms"],
    space: [0, 4, 8, 16, 32, 64, 128, 256, 512],
    breakpoints: ["414px", "576px", "768px", "1024px", "1200px", "1500px"],
    fontSizes: [12, 14, 16, 20, 24, 32, 48, 64, 72],
    fontWeights: [],
    lineHeights: [],
    letterSpacings: [],
    borders: [],
    zIndices: [],
    radii: [],
};

export { theme };
