// #region Global Imports
import { FunctionComponent } from "react";
import getConfig from "next/config";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import useMount from "@Helpers/useMount";
import useUnmount from "@Helpers/useUnMount";
// #endregion Local Imports

// #region Interface Imports
import { IReCaptcha } from "./ReCaptcha";
// #endregion Interface Imports
const {
    publicRuntimeConfig: { GOOGLE_RECAPTCHA_SITE_KEY },
} = getConfig();

const Component: FunctionComponent<IReCaptcha.IProps> = ({
    action,
    invisible,
    t,
}): JSX.Element => {
    const widgetId: string = "g-recaptcha";
    let widget: HTMLDivElement;

    const onLoad = (): void => {
        widget = document.createElement("div");
        widget.id = widgetId;
        document.body.appendChild(widget);

        window.grecaptcha.render(widgetId, {
            sitekey: GOOGLE_RECAPTCHA_SITE_KEY,
            size: "invisible",
        });
    };

    useMount((): void => {
        window.captchaOnLoad = onLoad;

        if (undefined === window.grecaptcha) {
            const url =
                "https://www.google.com/recaptcha/api.js?onload=captchaOnLoad&render=explicit&hl=ru";
            const script = document.createElement("script");
            script.type = "text/javascript";
            script.src = url;
            script.async = true;
            script.defer = true;
            document.body.appendChild(script);
        } else {
            onLoad();
        }
    });

    useUnmount((): void => {
        const el = document.getElementById(widgetId);
        if (el !== null) {
            document.body.removeChild(el);
        }
    });

    if (undefined !== invisible && invisible) {
        return (
            <style jsx global>
                {`
                    .grecaptcha-badge {
                        visibility: hidden;
                    }
                `}
            </style>
        );
    }

    return <></>;
};

const ReCaptcha = withTranslation("common")(Component);

export { ReCaptcha };
