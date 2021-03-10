// #region Global Imports
import { FunctionComponent } from "react";
import { useDispatch, useSelector } from "react-redux";
import css from "@styled-system/css";
// #endregion Global Imports

// #region Local Imports
import { Element, Text } from "@Components/Basic";
import { withTranslation } from "@Server/i18n";
import { StoreActions } from "@Actions";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { IPromoSelector } from "./PromoSelector";
// #endregion Interface Imports

const Component: FunctionComponent<IPromoSelector.IProps> = ({
    promoCount,
    slug,
}): JSX.Element => {
    const activePromoType = useSelector(
        (state: IStore) => state.Store.activePromoType
    );
    const dispatch = useDispatch();

    const handleSelectPromoType = (type: string) => {
        dispatch(
            StoreActions.GetPromos({
                params: {
                    "filter[slug]": slug,
                    "filter[type]": type,
                    "filter[is_expired]": false,
                    per_page: 10,
                    page: 1,
                    sort: "end_date",
                    direction: "asc",
                },
            })
        );
        dispatch(StoreActions.SelectPromoType(type));
    };

    return (
        <Element
            css={css({
                margin: "12px 0px",
                fontWeight: "600",
                color: "#757575",
                borderBottom: ["none", "1px solid #e0e0e0"],
            })}
        >
            <Element
                as="ul"
                css={css({
                    display: ["flex", null, null, null, "block"],
                    justifyContent: ["space-around", "space-between"],
                    margin: "0px",
                    padding: "0px",
                    flexWrap: ["wrap", "nowrap"],
                })}
            >
                {promoCount.count.map((promoType) => {
                    const color =
                        activePromoType === promoType.type
                            ? "#212121"
                            : "#757575";
                    const cursor =
                        activePromoType === promoType.type
                            ? "default"
                            : "pointer";
                    const afterWidth =
                        activePromoType === promoType.type ? "100%" : "0px";

                    return (
                        <Element
                            key={promoType.type}
                            as="li"
                            css={css({
                                display: "inline-block",
                                textAlign: "center",
                                transition: "0.2s",
                                color,
                                cursor,
                                margin: [
                                    "0px",
                                    null,
                                    null,
                                    null,
                                    "0px 0px 0px 25px",
                                ],
                                paddingBottom: ["15px", "0px"],
                                "::after": {
                                    content: '""',
                                    display: "block",
                                    width: afterWidth,
                                    height: "2px",
                                    backgroundColor: "#212121",
                                    margin: "8px auto -1px",
                                    transition: "0.2s",
                                },
                                ":first-child": {
                                    margin: "0px",
                                },
                            })}
                            onClick={() =>
                                handleSelectPromoType(promoType.type)
                            }
                        >
                            <Text as="span" padding="0px 5px" size={1}>
                                {`${promoType.name} (${promoType.count})`}
                            </Text>
                        </Element>
                    );
                })}
            </Element>
        </Element>
    );
};

const PromoSelector = withTranslation("common")(Component);

export { PromoSelector };
