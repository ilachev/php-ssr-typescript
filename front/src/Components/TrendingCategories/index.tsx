// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import {
    Grid,
    Column,
    Text,
    Element,
    Link as StyledLink,
} from "@Components/Basic";
import { Link, withTranslation } from "@Server/i18n";
// #endregion Local Imports

// #region Interface Imports
import { Picture } from "@Components/Basic/Picture";
import { ITrendingCategories } from "./TrendingCategories";

// #endregion Interface Imports

const Component: FunctionComponent<ITrendingCategories.IProps> = ({
    t,
    categories,
}): JSX.Element => {
    return (
        <Element
            css={css({
                display: "flex",
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
                    <Text as="h2" size={4}>
                        {t("common:TrendingCategories")}
                    </Text>
                </Column>
                <Column span={12}>
                    <Element
                        css={css({
                            position: "relative",
                        })}
                    >
                        <Grid columnGap={0}>
                            {categories.items.map((category) => {
                                return (
                                    <Column
                                        key={category.id}
                                        span={[6, 6, 4, 4, 3, 3, 2]}
                                        css={css({
                                            width: "100%",
                                            padding: "13px",
                                        })}
                                    >
                                        <Link
                                            href={`/categories/${category.slug}`}
                                        >
                                            <StyledLink
                                                href={`/categories/${category.slug}`}
                                            >
                                                <Element
                                                    css={css({
                                                        display: "flex",
                                                        flexFlow: "column",
                                                        justifyContent:
                                                            "space-around",
                                                        alignItems: "center",
                                                    })}
                                                >
                                                    <Element
                                                        css={css({
                                                            width: ["150px"],
                                                            height: ["150px"],
                                                            display: "flex",
                                                            overflow: "hidden",
                                                            position:
                                                                "relative",
                                                            minWidth: "100px",
                                                            minHeight: "100px",
                                                            alignItems:
                                                                "center",
                                                            justifyContent:
                                                                "center",
                                                            marginBottom:
                                                                "20px",
                                                            borderRadius: "5px",
                                                        })}
                                                    >
                                                        <Picture
                                                            alt={category.name}
                                                            src={`${category.logo.url}/${category.logo.name}?w=150&h=150`}
                                                            imageCss={{
                                                                objectFit:
                                                                    "cover",
                                                                opacity: "1",
                                                            }}
                                                            containerCss={{
                                                                width: "100%",
                                                                height: "100%",
                                                                display: "flex",
                                                                justifyContent:
                                                                    "center",
                                                            }}
                                                        />
                                                    </Element>
                                                    <Element
                                                        css={css({
                                                            textAlign: "center",
                                                        })}
                                                    >
                                                        <Text
                                                            as="span"
                                                            css={css({
                                                                height: "15px",
                                                            })}
                                                        >
                                                            {category.name}
                                                        </Text>
                                                    </Element>
                                                </Element>
                                            </StyledLink>
                                        </Link>
                                    </Column>
                                );
                            })}
                        </Grid>
                    </Element>
                </Column>
            </Grid>
        </Element>
    );
};

const TrendingCategories = withTranslation("common")(Component);

export { TrendingCategories };
