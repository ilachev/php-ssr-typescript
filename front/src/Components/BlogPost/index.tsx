// #region Global Imports
import { FunctionComponent } from "react";
import { useSelector } from "react-redux";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element, Text } from "@Components/Basic";
import { Picture } from "@Components/Basic/Picture";
import { withTranslation } from "@Server/i18n";
import { BlogComments } from "@Components/BlogComments";
import { HtmlProcessor } from "@Components/Basic";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { IBlogPost } from "./BlogPost";
// #endregion Interface Imports

const Component: FunctionComponent<IBlogPost.IProps> = ({
    post,
}): JSX.Element => {
    const comments = useSelector((state: IStore) => state.Blog.comments);
    const commentsCount = useSelector(
        (state: IStore) => state.Blog.commentsCount
    );

    return (
        <Element css={css({})}>
            <Element
                css={css({
                    margin: [null, null, null, "0px auto"],
                    padding: ["0px 5px", null, null, "0px 20px", "0px 90px"],
                    maxWidth: "860px",
                })}
            >
                <Element
                    as="h1"
                    css={css({
                        fontSize: "36px",
                        letterSpacing: "-1px",
                        lineHeight: "36px",
                        margin: "0px",
                        marginBottom: "30px",
                        textAlign: "center",
                    })}
                >
                    {post.name}
                </Element>
                <Element
                    css={css({
                        marginBottom: "30px",
                    })}
                >
                    <Element
                        css={css({
                            display: "flex",
                            flexFlow: "column",
                            marginBottom: "8px",
                            color: "#616161",
                            fontSize: "14px",
                            marginTop: "16px",
                            fontWeight: "500",
                            lineHeight: "16px",
                        })}
                    >
                        <Element
                            css={css({
                                display: "flex",
                                flexFlow: ["column", "row"],
                                alignItems: ["flex-start", "center"],
                            })}
                        >
                            <Element
                                css={css({
                                    display: "flex",
                                    marginBottom: ["15px", "0px"],
                                })}
                            >
                                <Picture
                                    alt={post.author.name}
                                    src={post.author.avatar}
                                    imageCss={{
                                        borderRadius: "100%",
                                        width: "100%",
                                        height: "100%",
                                        display: "inline-block",
                                        verticalAlign: "bottom",
                                    }}
                                    containerCss={{
                                        width: "32px",
                                        height: "32px",
                                    }}
                                />
                                <Element
                                    css={css({
                                        display: "flex",
                                        flexFlow: "column",
                                        marginLeft: "10px",
                                    })}
                                >
                                    <Element css={css({})}>
                                        {post.author.name}
                                    </Element>
                                    <Element
                                        as="time"
                                        dateTime={post.date_atom}
                                        css={css({})}
                                    >
                                        {post.date}
                                    </Element>
                                </Element>
                            </Element>

                            <Element
                                css={css({
                                    width: "1px",
                                    height: ["0px", "20px"],
                                    margin: "0px 10.5px",
                                    backgroundColor: "#e0e0e0",
                                })}
                            />

                            <Element css={css({})}>
                                {`💬 ${post.comments.info}`}
                            </Element>
                        </Element>
                    </Element>
                </Element>
                <Element
                    css={css({
                        fontSize: "17px",
                        fontWeight: "500",
                        lineHeight: "25px",
                        marginBottom: "40px",
                    })}
                >
                    <Text as="div">
                        <HtmlProcessor
                            html={post.description}
                            previewWidth={680}
                        />
                    </Text>
                </Element>

                <BlogComments
                    comments={comments}
                    commentsCount={commentsCount}
                    slug={post.slug}
                />
            </Element>
        </Element>
    );
};

const BlogPost = withTranslation("common")(Component);

export { BlogPost };
