// #region Global Imports
import { useEffect } from "react";
import { useDispatch } from "react-redux";
import { AppInitialProps, AppContext } from "next/app";
import NProgress from "nprogress";
import Head from "next/head";
import { ThemeProvider } from "styled-components";
import { YMInitializer } from "react-yandex-metrika";
import getConfig from "next/config";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled";
import { appWithTranslation, Router } from "@Server/i18n";
import { wrapper } from "@Redux";
import "@Static/styles/main.scss";
import { HeaderActions } from "@Actions";
import useAuth from "@Helpers/useAuth";
import { NotFound } from "@Components";
import { isClient } from "@Helpers/util";
// #endregion Local Imports

// Binding events.
NProgress.configure({ showSpinner: false });
Router.events.on("routeChangeStart", () => NProgress.start());
Router.events.on("routeChangeComplete", () => NProgress.done());
Router.events.on("routeChangeError", () => NProgress.done());

const {
    publicRuntimeConfig: { YANDEX_METRIKA_ID },
} = getConfig();
const { NODE_ENV } = process.env;
const MyApp = ({ Component, pageProps }): JSX.Element => {
    const dispatch = useDispatch();
    const [authInfo] = useAuth();

    useEffect(() => {
        if (undefined !== authInfo) {
            dispatch(
                HeaderActions.GetProfile({
                    authInfo: authInfo!,
                })
            );
        }
    }, [authInfo, dispatch]);

    useEffect(() => {
        dispatch(
            HeaderActions.GetSearchResults({
                "filter[q]": "a",
            })
        );
    }, [dispatch]);

    const PageHead = () => {
        return (
            <Head>
                <meta charSet="utf-8" />
                <title>{pageProps?.info?.seo?.meta?.title}</title>
                <meta
                    name="description"
                    content={pageProps?.info?.seo?.meta?.description}
                />
                <meta
                    name="viewport"
                    content="width=device-width, height=device-height,user-scalable=no, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0"
                />
                <meta name="google" content="notranslate" />
                <meta name="referrer" content="no-referrer-when-downgrade" />
                <meta
                    name="og:title"
                    property="og:title"
                    content={pageProps?.info?.seo?.meta?.og_title}
                />
                <meta
                    name="og:description"
                    property="og:description"
                    content={pageProps?.info?.seo?.meta?.og_description}
                />
                <meta
                    name="og:image"
                    property="og:image"
                    content="https://kuponopad.ru/static/images/og-kuponopad-ru.png"
                />
                <link rel="icon" type="image/x-icon" href="/favicon.ico" />
                <link
                    rel="apple-touch-icon"
                    sizes="152x152"
                    href="/static/images/touch-icon-ipad.png"
                />
                <link
                    rel="apple-touch-icon-precomposed"
                    sizes="152x152"
                    href="/static/images/touch-icon-ipad.png"
                />
            </Head>
        );
    };

    if (undefined !== pageProps.statusCode && pageProps.statusCode === 404) {
        return (
            <ThemeProvider theme={theme}>
                <PageHead />
                <NotFound />
                {NODE_ENV === "production" ? (
                    <YMInitializer
                        accounts={[parseInt(YANDEX_METRIKA_ID, 10)]}
                        options={{
                            clickmap: true,
                            trackLinks: true,
                            webvisor: true,
                            accurateTrackBounce: true,
                        }}
                        version="2"
                    />
                ) : null}
            </ThemeProvider>
        );
    }

    return (
        <ThemeProvider theme={theme}>
            <PageHead />
            <Component {...pageProps} />
            {NODE_ENV === "production" ? (
                <YMInitializer
                    accounts={[parseInt(YANDEX_METRIKA_ID, 10)]}
                    options={{
                        clickmap: true,
                        trackLinks: true,
                        webvisor: true,
                        accurateTrackBounce: true,
                    }}
                    version="2"
                />
            ) : null}
        </ThemeProvider>
    );
};

MyApp.getInitialProps = async ({
    Component,
    ctx,
}: AppContext): Promise<AppInitialProps> => {
    const pageProps: any = Component.getInitialProps
        ? await Component.getInitialProps(ctx)
        : {};

    if (undefined !== pageProps.statusCode && ctx.res) {
        ctx.res.statusCode = pageProps.statusCode;
    }

    return { pageProps };
};

export default wrapper.withRedux(appWithTranslation(MyApp));
