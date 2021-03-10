// #region Global Imports
import { addDecorator, addParameters } from "@storybook/react";
import { withThemesProvider } from "storybook-addon-styled-component-theme";
import { withKnobs } from "@storybook/addon-knobs";
import { INITIAL_VIEWPORTS } from "@storybook/addon-viewport";
// #endregion Global Imports

// #region Local Imports
import {theme} from "@Definitions/Styled"
import {withI18next} from "./Decorators"
import { createGlobalStyle } from "styled-components";
// #endregion Local Imports

const GlobalStyle = createGlobalStyle`
  html body {
    font-family: 'Inter', sans-serif;
    -webkit-font-smoothing: auto;
    -moz-font-smoothing: auto;
    -moz-osx-font-smoothing: grayscale;
    -webkit-text-size-adjust: 100%;
    -webkit-tap-highlight-color: transparent;
    -webkit-touch-callout: none;
    font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
    font-smooth: always;
    font-size: 16px;
    margin: 0;
    * {
      box-sizing: border-box;
    }
    a {
      color: #40a9f3;
    }
  }
`;

const withGlobal = (cb) => (
    <>
        <GlobalStyle />
        {cb()}
    </>
);

addDecorator(withGlobal);
addDecorator(withThemesProvider([{name: "light", ...theme}]));
addDecorator(withKnobs);
addDecorator(withI18next());

addParameters({
    viewport: {
        viewports: INITIAL_VIEWPORTS,
    },
});
