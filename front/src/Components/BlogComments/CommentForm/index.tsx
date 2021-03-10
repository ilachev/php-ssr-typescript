// #region Global Imports
import {
    ChangeEvent,
    FunctionComponent,
    useEffect,
    useRef,
    useState,
} from "react";
import css from "@styled-system/css";
import { useDispatch, useSelector } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Element, Link as StyledLink } from "@Components/Basic";
import useAuth from "@Helpers/useAuth";
import { executeCaptcha } from "@Helpers/util";
import { BlogActions, HeaderActions } from "@Actions";
import { theme } from "@Definitions/Styled";
import { ReCaptcha } from "@Components/Basic/ReCaptcha";
import { useError } from "@Helpers/useError";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { ICommentForm } from "./CommentForm";
// #endregion Interface Imports

const Component: FunctionComponent<ICommentForm.IProps> = ({
    parentCommentId,
}): JSX.Element => {
    const dispatch = useDispatch();
    const leaveComment = useSelector(
        (state: IStore) => state.Blog.leaveComment
    );
    const post = useSelector((state: IStore) => state.Blog.post);
    const pagination = useSelector(
        (state: IStore) => state.Blog.comments.pagination
    );
    const activeCommentId = useSelector(
        (state: IStore) => state.Blog.activeCommentId
    );
    const [isAuth, setIsAuth] = useState<boolean>(false);
    const [authInfo] = useAuth();
    const ref = useRef<HTMLTextAreaElement>(null);
    const [isTextError, textErrorTitle] = useError(
        "text",
        leaveComment.errors.violations
    );

    useEffect(() => {
        if (undefined !== authInfo) {
            setIsAuth(true);
        } else {
            setIsAuth(false);
        }
    }, [authInfo]);

    const handleOpenAuth = () => {
        dispatch(
            HeaderActions.Map({
                authModalIsOpen: true,
            })
        );
    };

    const handleCancel = () => {
        dispatch(
            BlogActions.Map({
                isBaseCommentFormActive: true,
                activeCommentId: "",
                leaveComment: {
                    data: {
                        text: "",
                    },
                    errors: {
                        violations: [],
                    },
                    status: "",
                },
            })
        );
    };

    const handleChangeComment = (e: ChangeEvent<HTMLInputElement>) => {
        dispatch(
            BlogActions.Map({
                leaveComment: {
                    ...leaveComment,
                    data: {
                        ...leaveComment.data,
                        text: e.target.value,
                    },
                    errors: {
                        violations: [],
                    },
                    status: "",
                },
            })
        );
    };

    const handleLeaveComment = async (execute: () => Promise<string>) => {
        const token = await execute();
        const res = await dispatch(
            BlogActions.LeaveComment({
                payload: {
                    // @ts-ignore
                    parentId: activeCommentId === "" ? null : activeCommentId,
                    text: leaveComment.data.text.trim(),
                    postId: post.id,
                    token,
                },
                authInfo: authInfo!,
            })
        );

        // @ts-ignore
        if (res.status === "success") {
            dispatch(
                BlogActions.GetCommentsCount({
                    params: {
                        "filter[slug]": post.slug,
                    },
                    authInfo: authInfo!,
                })
            );

            dispatch(
                BlogActions.GetComments({
                    params: {
                        "filter[slug]": post.slug,
                        per_page: pagination.per_page,
                        page: 1,
                        sort: "date",
                        direction: "desc",
                    },
                    authInfo: authInfo!,
                })
            );

            dispatch(
                BlogActions.Map({
                    isBaseCommentFormActive: true,
                    activeCommentId: "",
                })
            );

            dispatch(
                BlogActions.GetPost({
                    params: {
                        slug: post.slug,
                        categorySlug: post.category.slug,
                    },
                    authInfo: authInfo!,
                })
            );
        }
    };

    return (
        <Element>
            <Element
                css={css({
                    padding: "13px",
                    boxShadow: "0 1px 5px rgb(0 0 0 / 8%)",
                    borderRadius: "5px",
                    marginBottom: "15px",
                })}
            >
                <Element>
                    <Element
                        css={css({
                            fontSize: theme.fontSizes[1],
                            fontWeight: 700,
                            marginBottom: "12px",
                            lineHeight: 1,
                        })}
                    >
                        Оставьте комментарий
                    </Element>

                    <Element
                        as="form"
                        onSubmit={(e: Event) => e.preventDefault()}
                    >
                        <Element
                            css={css({
                                marginBottom: "15px",
                            })}
                        >
                            <Element
                                as="textarea"
                                rows={8}
                                css={css({
                                    display: "block",
                                    width: "100%",
                                    color: "#222",
                                    border: "1px solid #ddd",
                                    background: "#fff",
                                    borderRadius: "5px",
                                    padding: "10px 8px",
                                    fontSize: theme.fontSizes[1],
                                    ...(isTextError && {
                                        border: `1px solid ${theme.colors.danger}`,
                                    }),
                                })}
                                value={leaveComment.data.text}
                                onChange={handleChangeComment}
                                onFocus={(e: Event) => {
                                    e.preventDefault();
                                    if (!isAuth) {
                                        ref.current?.blur();
                                        return handleOpenAuth();
                                    }
                                    return null;
                                }}
                                ref={ref}
                            />
                        </Element>

                        {isTextError ? (
                            <Element
                                css={css({
                                    marginBottom: "15px",
                                    fontSize: theme.fontSizes[0],
                                    color: theme.colors.danger,
                                })}
                            >
                                {textErrorTitle}
                            </Element>
                        ) : null}

                        {isAuth ? (
                            <>
                                <ReCaptcha action="Comment" invisible />

                                <Element
                                    css={css({
                                        marginBottom: "15px",
                                        fontSize: theme.fontSizes[0],
                                    })}
                                >
                                    Защищено reCAPTCHA,{" "}
                                    <StyledLink
                                        target="_blank"
                                        href="//www.google.com/intl/ru/policies/privacy/"
                                    >
                                        конфиденциальность
                                    </StyledLink>{" "}
                                    и{" "}
                                    <StyledLink
                                        target="_blank"
                                        href="//www.google.com/intl/ru/policies/terms/"
                                    >
                                        условия использования
                                    </StyledLink>{" "}
                                    Google.
                                </Element>
                            </>
                        ) : null}

                        <Element
                            css={css({
                                display: ["flex", null, "block"],
                                justifyContent: [
                                    "space-between",
                                    null,
                                    "unset",
                                ],
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
                                    borderColor: "#3d68fb",
                                    backgroundColor: "#3d68fb",
                                    overflow: "hidden",
                                    width: ["100%", "auto"],
                                })}
                                onClick={
                                    !isAuth
                                        ? handleOpenAuth
                                        : () =>
                                              handleLeaveComment(executeCaptcha)
                                }
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
                                            color: "rgb(255, 255, 255)",
                                            order: 2,
                                            overflow: "hidden",
                                            fontWeight: 600,
                                            whiteSpace: "nowrap",
                                            fontStretch: "normal",
                                            textOverflow: "ellipsis",
                                            letterSpacing: "normal",
                                        })}
                                    >
                                        Отправить
                                    </Element>
                                </Element>
                            </Element>

                            {undefined !== parentCommentId ? (
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
                                        marginLeft: [0, "15px"],
                                        marginTop: ["15px", 0],
                                        width: ["100%", "auto"],
                                    })}
                                    onClick={handleCancel}
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
                                            Отменить
                                        </Element>
                                    </Element>
                                </Element>
                            ) : null}
                        </Element>
                    </Element>
                </Element>
            </Element>
        </Element>
    );
};

const CommentForm = withTranslation("common")(Component);

export { CommentForm };
