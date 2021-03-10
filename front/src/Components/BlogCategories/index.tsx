// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import { useDispatch } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import {
    Column,
    Element,
    Grid,
    Icon,
    Link as StyledLink,
    Text,
} from "@Components/Basic";
import { Link, withTranslation } from "@Server/i18n";
import { BlogActions } from "@Actions";
// #endregion Local Imports

// #region Interface Imports
import { Picture } from "@Components/Basic/Picture";
import { IBlogCategories } from "./BlogCategories";
// #endregion Interface Imports

const Component: FunctionComponent<IBlogCategories.IProps> = ({
    posts,
    h1,
    category,
}): JSX.Element => {
    const dispatch = useDispatch();

    const { pagination } = posts;
    const { slug } = category;

    const handleLoadMore = async () => {
        await dispatch(
            BlogActions.LoadMorePosts({
                params: {
                    "filter[category]": slug,
                    "filter[status]": "active",
                    per_page: pagination.per_page.toString(),
                    page: (pagination.page + 1).toString(),
                    sort: "date",
                    direction: "desc",
                },
            })
        );
    };

    return (
        <Element
            css={css({
                display: "flex",
                flexFlow: "column",
                alignItems: "center",
            })}
        >
            <Grid
                columnGap={0}
                css={css({
                    width: "100%",
                })}
            >
                <Column span={12}>
                    <Text as="h1" size={4}>
                        {h1}
                    </Text>
                </Column>
                <Column span={12}>
                    <Element
                        css={css({
                            display: "grid",
                            gridRowGap: "60px",
                            gridColumnGap: "40px",
                            gridTemplateColumns: [
                                "1fr 1fr",
                                null,
                                null,
                                null,
                                "1fr 1fr 1fr",
                            ],
                            gridAutoRows: "max-content",
                        })}
                    >
                        {posts.items.map((post) => {
                            return (
                                <Element
                                    key={post.id}
                                    as="article"
                                    css={css({
                                        gridColumnEnd: [
                                            "span 2",
                                            null,
                                            "span 1",
                                        ],
                                        width: "100%",
                                        height: "100%",
                                        display: "flex",
                                        flexDirection: "column",
                                    })}
                                >
                                    <Element>
                                        <Link
                                            href={`/${post.category.slug}/${post.slug}`}
                                        >
                                            <StyledLink
                                                href={`/${post.category.slug}/${post.slug}`}
                                            >
                                                <Picture
                                                    alt={post.name}
                                                    src={`${post.logo.url}/${post.logo.name}?w=350&h=220`}
                                                    imageCss={{
                                                        width: "100%",
                                                        cursor: "pointer",
                                                        height: "224px",
                                                        objectFit: "cover",
                                                        marginBottom: "10px",
                                                        borderRadius: "5px",
                                                    }}
                                                />
                                            </StyledLink>
                                        </Link>
                                    </Element>
                                    <Element
                                        css={css({
                                            display: "flex",
                                            flexFlow: "column",
                                            marginBottom: "8px",
                                            color: "#616161",
                                            fontSize: "17px",
                                            marginTop: "17px",
                                            fontWeight: "500",
                                        })}
                                    >
                                        <Element
                                            css={css({
                                                display: "flex",
                                                flexFlow: ["column", "row"],
                                                alignItems: [
                                                    "flex-start",
                                                    "center",
                                                ],
                                                fontSize: "12px",
                                                fontWeight: "500",
                                                lineHeight: "16px",
                                            })}
                                        >
                                            <Element
                                                css={css({
                                                    display: "flex",
                                                    marginBottom: [
                                                        "15px",
                                                        "0px",
                                                    ],
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
                                                        dateTime={
                                                            post.date_atom
                                                        }
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
                                    <Link
                                        href={`/${post.category.slug}/${post.slug}`}
                                    >
                                        <StyledLink
                                            href={`/${post.category.slug}/${post.slug}`}
                                            css={css({
                                                fontSize: "22px",
                                                fontFamily:
                                                    "Roboto, sans-serif",
                                                fontWeight: "700",
                                                marginBottom: "8px",
                                            })}
                                        >
                                            {post.name}
                                        </StyledLink>
                                    </Link>
                                    <Text
                                        as="p"
                                        size={1}
                                        margin="0px"
                                        dangerouslySetInnerHTML={{
                                            __html: post.description,
                                        }}
                                    />
                                </Element>
                            );
                        })}
                    </Element>
                </Column>
            </Grid>

            {pagination.pages !== 0 && pagination.page !== pagination.pages ? (
                <Element
                    as="button"
                    css={css({
                        width: "170px",
                        border: "1px solid #bdbdbd",
                        cursor: "pointer",
                        height: "42px",
                        margin: "auto",
                        display: "flex",
                        marginTop: "50px",
                        textAlign: "center",
                        transition: "0.2s",
                        alignItems: "center",
                        borderRadius: "5px",
                        justifyContent: "center",
                        backgroundColor: "#ffffff",
                        fontSize: "14px",
                        fontWeight: "600",
                        lineHeight: "16px",
                    })}
                    onClick={handleLoadMore}
                >
                    Показать ещё
                    <Icon
                        css={css({
                            marginLeft: "5px",
                        })}
                        name="arrowDown"
                    />
                </Element>
            ) : null}
        </Element>
    );
};

const BlogCategories = withTranslation("common")(Component);

export { BlogCategories };
