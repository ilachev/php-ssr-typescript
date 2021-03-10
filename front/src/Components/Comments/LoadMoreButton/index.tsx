// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import { useDispatch } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Element } from "@Components/Basic";
import { StoreActions } from "@Actions";
import useAuth from "@Helpers/useAuth";
// #endregion Local Imports

// #region Interface Imports
import { ILoadMoreButton } from "./LoadMoreButton";
// #endregion Interface Imports

const Component: FunctionComponent<ILoadMoreButton.IProps> = ({
    pagination,
    slug,
}): JSX.Element => {
    const dispatch = useDispatch();
    const [authInfo] = useAuth();

    const handleLoadMore = () => {
        dispatch(
            StoreActions.LoadMoreComments({
                params: {
                    "filter[slug]": slug,
                    per_page: pagination.per_page,
                    page: pagination.page + 1,
                    sort: "date",
                    direction: "desc",
                },
                authInfo: authInfo!,
            })
        );
    };

    return (
        <Element
            css={css({
                display: ["flex", null, "block"],
                justifyContent: ["space-between", null, "unset"],
                flexWrap: "wrap",
            })}
        >
            <Element
                as="button"
                css={css({
                    cursor: "pointer",
                    height: "40px",
                    outline: "none",
                    padding: "0px 16px",
                    background: "none",
                    boxShadow: "none",
                    transition: "all 0.2s ease 0s",
                    textShadow: "none",
                    borderStyle: "solid",
                    borderWidth: "1px",
                    borderRadius: "5px",
                    borderColor: "#bdbdbd",
                    backgroundColor: "#f5f5f5",
                    overflow: "hidden",
                    marginBottom: "15px",
                    width: "100%",
                })}
                onClick={handleLoadMore}
            >
                <Element
                    css={css({
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                    })}
                >
                    <Element
                        css={css({
                            fontSize: "14px",
                            color: "#212121",
                            order: 2,
                            overflow: "hidden",
                            fontWeight: 600,
                            whiteSpace: "nowrap",
                            fontStretch: "normal",
                            textOverflow: "ellipsis",
                            letterSpacing: "normal",
                        })}
                    >
                        Ещё комментарии
                    </Element>
                </Element>
            </Element>
        </Element>
    );
};

const LoadMoreButton = withTranslation("common")(Component);

export { LoadMoreButton };
