// #region Global Imports
import { FunctionComponent, useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Element, Text } from "@Components/Basic";
import { theme } from "@Definitions/Styled";
import { Picture } from "@Components/Basic/Picture";
import { Children } from "@Components/BlogComments/Children";
import { CommentForm } from "@Components/BlogComments/CommentForm";
import useAuth from "@Helpers/useAuth";
import { BlogActions, HeaderActions } from "@Actions";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { IComment } from "./Comment";
// #endregion Interface Imports

const Component: FunctionComponent<IComment.IProps> = ({
    comment,
}): JSX.Element => {
    const dispatch = useDispatch();
    const activeCommentId = useSelector(
        (state: IStore) => state.Blog.activeCommentId
    );
    const [isAuth, setIsAuth] = useState(false);
    const [authInfo] = useAuth();

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

    const handleReply = () => {
        dispatch(
            BlogActions.Map({
                isBaseCommentFormActive: false,
                activeCommentId: comment.id,
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

    const childrenComments = (comment.children || []).map((comment) => {
        return (
            <Children key={comment.id}>
                <Comment comment={comment} />
            </Children>
        );
    });

    return (
        <>
            <Element
                css={css({
                    display: "flex",
                    flexWrap: "wrap",
                    flexDirection: "row",
                    padding: "13px",
                    boxShadow: "0 1px 5px rgb(0 0 0 / 8%)",
                    borderRadius: "5px",
                    marginBottom: "15px",
                })}
            >
                <Element
                    css={css({
                        width: "55px",
                    })}
                >
                    <Picture alt="Аватар" src={comment.avatar} />
                </Element>

                <Element
                    css={css({
                        width: "calc(100% - 55px)",
                    })}
                >
                    <Element
                        css={css({
                            display: "flex",
                            flexWrap: "wrap",
                            flexDirection: "row",
                            lineHeight: 1,
                            marginBottom: "10px",
                            alignItems: "center",
                        })}
                    >
                        <Element
                            css={css({
                                display: "flex",
                                alignItems: ["baseline", "center"],
                                flexFlow: ["column-reverse", "row"],
                            })}
                        >
                            <Element
                                css={css({
                                    fontSize: theme.fontSizes[1],
                                    fontWeight: 700,
                                })}
                            >
                                {comment.author_name}
                            </Element>

                            {comment.user_role !== null ? (
                                <Element
                                    css={css({
                                        backgroundColor: "#cc4b06",
                                        color: "#fff",
                                        marginLeft: ["0px", "10px"],
                                        marginBottom: ["10px", "0px"],
                                        padding: "5px",
                                        fontWeight: "600",
                                        fontSize: "12px",
                                        borderRadius: "5px",
                                    })}
                                >
                                    Администратор
                                </Element>
                            ) : null}
                        </Element>
                        <Element
                            as="time"
                            dateTime={comment.date_atom}
                            css={css({
                                marginLeft: "auto",
                                fontSize: theme.fontSizes[0],
                                color: "#aaa",
                                display: ["none", null, null, "block"],
                            })}
                        >
                            {comment.date}
                        </Element>
                    </Element>

                    <Element>
                        <Element
                            css={css({
                                fontSize: theme.fontSizes[1],
                                lineHeight: 1.3,
                                marginBottom: "10px",
                            })}
                        >
                            <Text
                                as="div"
                                size={1}
                                margin="0px"
                                dangerouslySetInnerHTML={{
                                    __html: comment.text || "",
                                }}
                            />
                        </Element>
                    </Element>

                    <Element
                        css={css({
                            lineHeight: 1,
                            fontSize: theme.fontSizes[0],
                        })}
                    >
                        <Element
                            css={css({
                                display: "inline-block",
                                color: "#666",
                                borderBottom: "1px dashed #666",
                                textDecoration: "none",
                                cursor: "pointer",
                                marginRight: "6px",
                            })}
                            onClick={!isAuth ? handleOpenAuth : handleReply}
                        >
                            Ответить
                        </Element>
                    </Element>
                </Element>
            </Element>

            {activeCommentId === comment.id ? (
                <Children>
                    <CommentForm parentCommentId={comment.id} />
                </Children>
            ) : null}

            {childrenComments}
        </>
    );
};

const Comment = withTranslation("common")(Component);

export { Comment };
