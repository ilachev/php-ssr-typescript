// #region Global Imports
import { useSelector } from "react-redux";
import { FunctionComponent } from "react";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element, Text } from "@Components/Basic";
import { PromoSelector } from "@Components/Store/PromoSelector";
import { StoreSidebar } from "@Components/Store/StoreSidebar";
import { Promos } from "@Components/Store/Promos";
import { useWindowSize } from "@Helpers";
import { theme } from "@Definitions/Styled";
import { Detail } from "@Components/Store/Detail";
import { Info } from "@Components/Store/Info";
import { OldPromos } from "@Components/Store/OldPromos";
import { Comments } from "@Components/Comments";
import { withTranslation } from "@Server/i18n";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { IStorePage } from "./Store";
// #endregion Interface Imports

const Component: FunctionComponent<IStorePage.IProps> = ({
    store,
    h1,
    seoDescription,
}): JSX.Element => {
    const [width] = useWindowSize();
    const breakWidth = parseInt(theme.breakpoints[3], 10);

    const promoCount = useSelector((state: IStore) => state.Store.promoCount);
    const comments = useSelector((state: IStore) => state.Store.comments);
    const commentsCount = useSelector(
        (state: IStore) => state.Store.commentsCount
    );

    return (
        <Element
            css={css({
                display: "flex",
                flexDirection: ["column", null, null, null, "row"],
            })}
        >
            <StoreSidebar
                h1={h1}
                description={store.description}
                info={store.info}
                name={store.name}
                logo={store.logo}
                seoDescription={seoDescription}
            />

            <Element
                css={css({
                    display: "flex",
                    flexDirection: "column",
                    width: "100%",
                    height: "auto",
                    margin: ["0px auto", null, null, null, "0px 0px 0px 30px"],
                    minWidth: ["0px", null, null, null, "650px"],
                    position: "initial",
                })}
            >
                {width > breakWidth ? (
                    <Element
                        css={css({
                            display: ["none", null, null, null, "flex"],
                            flexFlow: "column",
                            width: "100%",
                            marginBottom: "12px",
                        })}
                    >
                        <Text as="h1" size={3} marginTop="0px">
                            {h1}
                        </Text>
                        <Text as="p" size={1} marginTop="0px">
                            {seoDescription}
                        </Text>
                    </Element>
                ) : null}

                <PromoSelector promoCount={promoCount} slug={store.slug} />

                <Promos />
                <OldPromos />

                {store.info.detail !== null &&
                undefined !== store.info.detail ? (
                    <Detail detail={store.info.detail} />
                ) : null}

                {width < breakWidth ? (
                    <Info description={store.description} info={store.info} />
                ) : null}

                <Comments
                    comments={comments}
                    commentsCount={commentsCount}
                    slug={store.slug}
                />
            </Element>
        </Element>
    );
};

const Store = withTranslation("common")(Component);

export default Store;

export { Store };
