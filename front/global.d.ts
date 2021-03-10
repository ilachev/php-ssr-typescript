declare namespace NodeJS {
    interface ProcessEnv {
        PROXY_MODE: string;
        STATIC_PATH: string;
        API_URL: string;
        API_URL_BROWSER: string;
        API_KEY: string;
        TZ: string;
        GOOGLE_RECAPTCHA_SITE_KEY: string;
        OAUTH2_CLIENT_ID: string;
        YANDEX_METRIKA_ID: string;
    }
}

declare namespace jest {
    interface Options {
        media?: string;
        modifier?: string;
        supports?: string;
    }

    interface Matchers<R> {
        toHaveStyleRule(property: string, value?: Value, options?: Options): R;
    }
}
