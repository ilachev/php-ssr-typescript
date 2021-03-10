// #region Global Imports
import { WithTranslation } from "next-i18next";
import { Violation } from "@Interfaces/Violation";
// #endregion Global Imports

declare namespace IHeader {
    export interface IProps extends WithTranslation {}

    export interface IState {}

    export interface IStateProps {
        mobileMenuIsOpen: boolean;
        registrationModalIsOpen: boolean;
        authModalIsOpen: boolean;
        recoveryModalIsOpen: boolean;
        height: number;
        auth: {
            access_token: string;
            expires_in: number;
            refresh_token: string;
            token_type: string;
        };
        logIn: {
            data: {
                username: string;
                password: string;
            };
            errors: {
                error: string;
            };
            status?: string;
        };
        signUp: {
            data: {
                first_name: string;
                last_name: string;
                email: string;
                password: string;
            };
            errors: {
                violations: Array<Violation>;
            };
            status?: string;
        };
        reset: {
            data: {
                email: string;
            };
            errors: {
                violations: Array<Violation>;
            };
            status?: string;
        };
        profile: {
            id: string;
            email: string;
            avatar: {
                url: string;
            };
            name: string;
        };
        search: {
            stores: [
                {
                    name: string;
                    link: string;
                }
            ];
            posts: [
                {
                    name: string;
                    link: string;
                }
            ];
        };
        query: string;
        resultsIsOpen: boolean;
    }

    module Actions {
        export interface IMapPayload {
            error?: string;
            access_token?: string;
        }
        export interface IMapResponse {}
    }
}

export { IHeader };
