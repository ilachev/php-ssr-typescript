const withPlugins = require("next-compose-plugins");
const withCSS = require("@zeit/next-css");
const withSass = require("@zeit/next-sass");
const withBundleAnalyzer = require("@zeit/next-bundle-analyzer");
const nextRuntimeDotenv = require("next-runtime-dotenv");

const withConfig = nextRuntimeDotenv({
    public: [
        "API_URL",
        "API_URL_BROWSER",
        "API_KEY",
        "TZ",
        "GOOGLE_RECAPTCHA_SITE_KEY",
        "OAUTH2_CLIENT_ID",
        "YANDEX_METRIKA_ID",
    ]
});

const nextConfig = {
    analyzeServer: ["server", "both"].includes(process.env.BUNDLE_ANALYZE),
    analyzeBrowser: ["browser", "both"].includes(process.env.BUNDLE_ANALYZE),
    bundleAnalyzerConfig: {
        server: {
            analyzerMode: "static",
            reportFilename: "../bundles/server.html",
        },
        browser: {
            analyzerMode: "static",
            reportFilename: "../bundles/client.html",
        },
    },
    publicRuntimeConfig: {
        PROXY_MODE: process.env.PROXY_MODE,
        API_URL: process.env.API_URL,
        API_URL_BROWSER: process.env.API_URL_BROWSER,
        API_KEY: process.env.API_KEY,
        STATIC_PATH: process.env.STATIC_PATH,
        TZ: process.env.TZ,
        GOOGLE_RECAPTCHA_SITE_KEY: process.env.GOOGLE_RECAPTCHA_SITE_KEY,
        OAUTH2_CLIENT_ID: process.env.OAUTH2_CLIENT_ID,
        YANDEX_METRIKA_ID: process.env.YANDEX_METRIKA_ID,
    },
    poweredByHeader: false,
};

module.exports = withConfig(
    withPlugins([[withCSS], [withSass], [withBundleAnalyzer]], nextConfig)
);
