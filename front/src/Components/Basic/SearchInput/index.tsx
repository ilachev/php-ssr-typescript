// #region Global Imports
import { ChangeEvent, FunctionComponent, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useRouter } from "next/router";
import styled from "styled-components";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { theme } from "@Definitions/Styled/theme";
import { IStore } from "@Redux/IStore";
import { withTranslation } from "@Server/i18n";
import { HeaderActions } from "@Actions";
import { useDebounce } from "@Helpers";
import { Element } from "../Element";
// #endregion Local Imports

const SearchIconBase = (props) => (
    <svg
        viewBox="0 0 11 11"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        width="22"
        height="22"
        {...props}
    >
        <path
            fillRule="evenodd"
            clipRule="evenodd"
            d="M6.966 7.932a4.15 4.15 0 01-2.69.993C1.916 8.925 0 6.927 0 4.463 0 1.998 1.915 0 4.277 0s4.276 1.998 4.276 4.463c0 1.063-.356 2.04-.951 2.806L12 11.86l-.635.663-4.399-4.59zm.689-3.47c0 1.947-1.513 3.525-3.378 3.525C2.41 7.987.899 6.41.899 4.463.899 2.516 2.41.938 4.277.938c1.865 0 3.378 1.578 3.378 3.525z"
        />
    </svg>
);

export const SearchIcon = styled(SearchIconBase)(
    css({
        position: "absolute",
        top: "50%",
        transform: "translateY(-50%)",
        left: "8px",

        path: {
            fill: theme.colors.input.placeholderForeground,
        },
    })
);

const Component: FunctionComponent = (): JSX.Element => {
    const dispatch = useDispatch();
    const router = useRouter();

    const search = useSelector((state: IStore) => state.Header.search);
    const query = useSelector((state: IStore) => state.Header.query);

    const [resultsIsOpen, setResultsIsOpen] = useState(false);

    const handleChangeName = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            HeaderActions.Map({
                query: e.target.value,
            })
        );
    };

    const handleSelectResult = (link: string) => {
        dispatch(
            HeaderActions.Map({
                query: "",
            })
        );
        setResultsIsOpen(false);
        router.push(link);
    };

    useDebounce(
        () => {
            if (query !== "") {
                dispatch(
                    HeaderActions.GetSearchResults({
                        "filter[q]": query,
                    })
                );
            }
        },
        800,
        [dispatch, query]
    );

    return (
        <>
            <Element css={{ position: "relative" }}>
                <SearchIcon />

                <Element
                    placeholder="Поиск"
                    as="input"
                    css={css({
                        paddingLeft: "36px",
                        fontSize: 1,
                        fontWeight: 600,
                        lineHeight: "20px",
                        height: "40px",
                        borderRadius: "5px",
                        backgroundColor: theme.colors.input.background,
                        color: theme.colors.input.foreground,
                        border: "none",
                        transition: "all 100ms ease 0s",
                        width: "100%",
                        ":focus": {
                            backgroundColor: theme.colors.input.focusBackground,
                            borderColor: theme.colors.inputOption.activeBorder,
                            outline: "none",
                            border: "1px solid",
                        },
                        ":disabled": {
                            opacity: 0.4,
                            borderColor: theme.colors.input.border,
                        },
                    })}
                    value={query}
                    onChange={handleChangeName}
                    onClick={() => setResultsIsOpen(true)}
                />
            </Element>

            {resultsIsOpen ? (
                <Element
                    css={css({
                        left: ["50%", null, null, null, "auto"],
                        right: ["50%", null, null, null, "auto"],
                        width: ["100vw", null, null, null, "610px"],
                        marginLeft: ["-50vw", null, null, null, "auto"],
                        marginRight: ["-50vw", null, null, null, "auto"],
                        position: "absolute",
                        zIndex: "3",
                    })}
                >
                    {search.posts.length > 0 || search.stores.length > 0 ? (
                        <Element
                            css={css({
                                width: "100%",
                                position: "absolute",
                            })}
                        >
                            <Element
                                css={css({
                                    borderRadius: "5px",
                                    borderTopLeftRadius: "initial",
                                    borderTopRightRadius: "initial",
                                    boxShadow: "none",
                                    left: "0px",
                                    marginLeft: "0px",
                                    marginTop: "0px",
                                    right: "0px",
                                    top: "12px",
                                    width: "100%",
                                    zIndex: "3",
                                    position: "absolute",
                                    overflowY: "auto",
                                    backgroundColor: "#fff",
                                })}
                            >
                                {search.stores.length > 0 ? (
                                    <Element
                                        css={css({
                                            margin: "10px 0px",
                                        })}
                                    >
                                        <Element
                                            as="h3"
                                            css={css({
                                                fontSize: "11px",
                                                fontWeight: "600",
                                                letterSpacing: "1.1px",
                                                lineHeight: "16px",
                                                textTransform: "uppercase",
                                                color: "#424242",
                                                margin: "0 10px 4px",
                                                borderBottom:
                                                    "1px solid #eeeeee",
                                            })}
                                        >
                                            Магазины
                                        </Element>

                                        {search.stores.map((store) => {
                                            return (
                                                <Element
                                                    key={store.link}
                                                    css={css({
                                                        color: "#212121",
                                                        width: "100%",
                                                        cursor: "pointer",
                                                        height: "100%",
                                                        overflow: "hidden",
                                                        paddingTop: "5px",
                                                        paddingLeft: "10px",
                                                        paddingRight: "10px",
                                                        paddingBottom: "5px",
                                                        backgroundColor: "#fff",
                                                    })}
                                                    onClick={() =>
                                                        handleSelectResult(
                                                            store.link
                                                        )
                                                    }
                                                >
                                                    <Element as="span">
                                                        {store.name}
                                                    </Element>
                                                </Element>
                                            );
                                        })}
                                    </Element>
                                ) : null}

                                {search.posts.length > 0 ? (
                                    <Element
                                        css={css({
                                            margin: "10px 0px",
                                        })}
                                    >
                                        <Element
                                            as="h3"
                                            css={css({
                                                fontSize: "11px",
                                                fontWeight: "600",
                                                letterSpacing: "1.1px",
                                                lineHeight: "16px",
                                                textTransform: "uppercase",
                                                color: "#424242",
                                                margin: "0 10px 4px",
                                                borderBottom:
                                                    "1px solid #eeeeee",
                                            })}
                                        >
                                            Статьи
                                        </Element>

                                        {search.posts.map((post) => {
                                            return (
                                                <Element
                                                    key={post.link}
                                                    css={css({
                                                        color: "#212121",
                                                        width: "100%",
                                                        cursor: "pointer",
                                                        height: "100%",
                                                        overflow: "hidden",
                                                        paddingTop: "5px",
                                                        paddingLeft: "10px",
                                                        paddingRight: "10px",
                                                        paddingBottom: "5px",
                                                        backgroundColor: "#fff",
                                                    })}
                                                    onClick={() =>
                                                        handleSelectResult(
                                                            post.link
                                                        )
                                                    }
                                                >
                                                    <Element as="span">
                                                        {post.name}
                                                    </Element>
                                                </Element>
                                            );
                                        })}
                                    </Element>
                                ) : null}
                            </Element>
                        </Element>
                    ) : null}

                    {search.posts.length > 0 || search.stores.length > 0 ? (
                        <Element
                            css={css({
                                left: "50%",
                                right: "50%",
                                width: "100vw",
                                height: "100%",
                                opacity: "1",
                                zIndex: "2",
                                position: "fixed",
                                marginTop: "12px",
                                transition: "visibility, opacity .1s ease",
                                visibility: "visible",
                                marginLeft: "-50vw",
                                marginRight: "-50vw",
                                backgroundColor: "rgba(0,0,0,.25)",
                            })}
                            onClick={() => setResultsIsOpen(false)}
                        />
                    ) : null}
                </Element>
            ) : null}
        </>
    );
};

const SearchInput = withTranslation("common")(Component);

export { SearchInput };
