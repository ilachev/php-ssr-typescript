// #region Global Imports
import { FunctionComponent } from "react";
import css from "@styled-system/css";
import { Swiper, SwiperSlide } from "swiper/react";
import SwiperCore, { Navigation, Scrollbar, A11y } from "swiper";
// #endregion Global Imports

// #region Local Imports
import {
    Grid,
    Column,
    Text,
    Element,
    Link as StyledLink,
} from "@Components/Basic";
import { Picture } from "@Components/Basic/Picture";
import { Link, withTranslation } from "@Server/i18n";
import { theme } from "@Definitions/Styled/theme";
import { useWindowSize } from "@Helpers";
// #endregion Local Imports

// #region Interface Imports
import { ITrendingStores } from "./TrendingStores";
// #endregion Interface Imports

const slideStyles = {
    border: "1px solid #eeeeee",
    display: "flex",
    padding: "16px 16px 12px",
    boxSizing: "border-box",
    textAlign: "left",
    marginRight: "16px",
    borderRadius: "5px",
    flexDirection: "column",
    justifyContent: "space-around",
    backgroundColor: "#ffffff",
};

const Slide = (props) => {
    const { store } = props;
    return (
        <Element
            css={css({
                ...slideStyles,
            })}
        >
            <Link href={`/stores/${store.slug}`}>
                <StyledLink href={`/stores/${store.slug}`}>
                    <Element
                        css={css({
                            margin: "16px 28px 16px 28px",
                            display: "flex",
                            justifyContent: "space-around",
                        })}
                    >
                        <Element
                            css={css({
                                width: "100px",
                                height: "100px",
                                display: "flex",
                                overflow: "hidden",
                                position: "relative",
                                minWidth: "100px",
                                minHeight: "100px",
                                alignItems: "center",
                                borderRadius: "50%",
                                justifyContent: "center",
                            })}
                        >
                            <Picture
                                alt={store.name}
                                src={`${store.logo.url}/${store.logo.name}?w=100&h=68`}
                                imageCss={{
                                    width: "100%",
                                    alignSelf: "center",
                                }}
                                containerCss={{
                                    width: "100%",
                                    height: "100%",
                                    display: "flex",
                                    justifyContent: "center",
                                }}
                            />
                        </Element>
                    </Element>
                    <Element
                        css={css({
                            textAlign: "center",
                        })}
                    >
                        <Text as="span" size={2}>
                            {store.name}
                        </Text>
                    </Element>
                </StyledLink>
            </Link>
        </Element>
    );
};

const SwiperDesktop = (props) => {
    const { stores } = props;

    SwiperCore.use([Navigation, A11y]);

    return (
        <Swiper slidesPerView={6} navigation>
            {stores.items.map((store) => {
                return (
                    <SwiperSlide key={store.id}>
                        <Slide store={store} />
                    </SwiperSlide>
                );
            })}
        </Swiper>
    );
};

const SwiperMobile = (props) => {
    const { stores } = props;

    SwiperCore.use([Scrollbar, A11y]);

    return (
        <Swiper
            slidesPerView="auto"
            scrollbar={{
                draggable: true,
                hide: true,
            }}
            freeMode
        >
            {stores.items.map((store) => {
                return (
                    <SwiperSlide key={store.id}>
                        <Slide store={store} />
                    </SwiperSlide>
                );
            })}
        </Swiper>
    );
};

const Component: FunctionComponent<ITrendingStores.IProps> = ({
    t,
    stores,
}): JSX.Element => {
    const [width] = useWindowSize();
    const breakWidth = parseInt(theme.breakpoints[3], 10);

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
                        {t("common:TrendingStores")}
                    </Text>
                </Column>
                <Column
                    span={12}
                    css={css({
                        minWidth: "0",
                    })}
                >
                    <Element
                        css={css({
                            display: "block",
                            margin: "0px -16px 0px 0px",
                        })}
                    >
                        {width > breakWidth ? (
                            <SwiperDesktop stores={stores} />
                        ) : (
                            <SwiperMobile stores={stores} />
                        )}
                    </Element>
                </Column>
            </Grid>
        </Element>
    );
};

const TrendingStores = withTranslation("common")(Component);

export default TrendingStores;
export { TrendingStores };
