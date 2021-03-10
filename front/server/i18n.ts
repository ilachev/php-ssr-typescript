// #region Global Imports
import NextI18Next from "next-i18next";
// #endregion Global Imports

// const langs = {
//     defaultLanguage: "ru",
//         otherLanguages: ["en"],
//         localeSubpaths: {
//         en: 'en'
//     }
// }

const NextI18NextInstance = new NextI18Next({
    defaultLanguage: "ru",
    otherLanguages: [""],
});

export const {
    appWithTranslation,
    withTranslation,
    Link,
    Router,
    i18n,
} = NextI18NextInstance;

export default NextI18NextInstance;
