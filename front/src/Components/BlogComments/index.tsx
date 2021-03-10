// #region Global Imports
import { FunctionComponent } from "react";
import { useSelector } from "react-redux";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { withTranslation } from "@Server/i18n";
import { Element, Text } from "@Components/Basic";
import { Comment } from "@Components/BlogComments/Comment";
import { CommentForm } from "@Components/BlogComments/CommentForm";
import { LoadMoreButton } from "@Components/BlogComments/LoadMoreButton";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { IComments } from "./BlogComments";
// #endregion Interface Imports

const Component: FunctionComponent<IComments.IProps> = ({
    commentsCount,
    comments,
    slug,
}): JSX.Element => {
    const isFormActive = useSelector(
        (state: IStore) => state.Blog.isBaseCommentFormActive
    );

    return (
        <Element>
            <Element
                css={css({
                    margin: "20px 0",
                })}
            >
                <Text as="h2" size={3}>
                    Комментарии
                    {commentsCount.count > 0 ? ` (${commentsCount.count})` : ``}
                </Text>
            </Element>

            <Element
                css={css({
                    display: "block",
                    width: "100%",
                    marginBottom: "30px",
                    padding: "18px",
                    border: "1px solid #e0e0e0",
                    borderRadius: "5px",
                    backgroundColor: "#fff",
                    fontSize: "14px",
                })}
            >
                {comments.items.map((comment) => {
                    return <Comment comment={comment} key={comment.id} />;
                })}

                {comments.pagination.pages !== 0 &&
                comments.pagination.page !== comments.pagination.pages ? (
                    <LoadMoreButton
                        pagination={comments.pagination}
                        slug={slug}
                    />
                ) : null}

                {isFormActive ? <CommentForm /> : null}
            </Element>
        </Element>
    );
};

const BlogComments = withTranslation("common")(Component);

export { BlogComments };
