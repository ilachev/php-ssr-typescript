// #region Global Imports
import "isomorphic-unfetch";
import getConfig from "next/config";
import { stringify } from "query-string";
// #endregion Global Imports

// #region Interface Imports
import { AuthInfo, HttpModel } from "@Interfaces";
// #endregion Interface Imports

const {
    publicRuntimeConfig: { API_URL, API_URL_BROWSER },
} = getConfig();

const BaseUrl =
    typeof window === "undefined" ? `${API_URL}` : `${API_URL_BROWSER}`;

export const Http = {
    Request: async <A>(
        methodType: string,
        url: string,
        params?: HttpModel.IRequestQueryPayload,
        payload?: HttpModel.IRequestPayload,
        contentType?: string,
        authInfo?: AuthInfo
    ): Promise<A> => {
        return new Promise((resolve, reject) => {
            const query = params ? `?${stringify({ ...params })}` : "";

            let body;
            if (undefined === contentType) {
                body = JSON.stringify(payload);
            } else if (undefined !== payload) {
                const formData = new FormData();
                Object.keys(payload).forEach((key: string) =>
                    formData.append(key, payload[key])
                );
                body = new URLSearchParams(formData as any);
            }

            let authHeader = {};
            if (undefined !== authInfo) {
                authHeader = {
                    Authorization: `${authInfo.token_type} ${authInfo.access_token}`,
                };
            }

            fetch(`${BaseUrl}${url}${query}`, {
                body,
                cache: "no-cache",
                headers: {
                    "Content-Type": contentType || "application/json",
                    ...authHeader,
                },
                method: `${methodType}`,
            })
                .then(async (response) => {
                    if (response.status === 200) {
                        return response.json().then(resolve);
                    }
                    if (response.status === 401) {
                        return reject(response);
                    }
                    if (response.status === 404) {
                        return reject(response);
                    }
                    return reject(response.json());
                })
                .catch((e) => {
                    return reject(e);
                });
        });
    },
};
