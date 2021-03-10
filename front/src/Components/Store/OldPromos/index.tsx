// #region Global Imports
import { withTranslation } from "@Server/i18n";
import { FunctionComponent, useEffect, useRef, useState } from "react";
import css from "@styled-system/css";
import ReactPaginate from "react-paginate";
import { useDispatch, useSelector } from "react-redux";
// #endregion Global Imports

// #region Local Imports
import { Promo } from "@Components/Promo";
import { Element, Text } from "@Components/Basic";
import { StoreActions } from "@Actions";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { IOldPromos } from "./OldPromos";
// #endregion Interface Imports

const Component: FunctionComponent<IOldPromos.IProps> = (): JSX.Element => {
    const promos = useSelector((state: IStore) => state.Store.old_promos);
    const store = useSelector((state: IStore) => state.Store.store);
    const headerHeight = useSelector((state: IStore) => state.Header.height);
    const dispatch = useDispatch();
    const [isPaginated, setIsPaginated] = useState(false);

    const h2Ref = useRef<HTMLElement>(null);

    const handlePageChange = (data) => {
        if (data.selected + 1 === promos.pagination.page) {
            return null;
        }

        dispatch(
            StoreActions.GetOldPromos({
                params: {
                    "filter[slug]": store.slug,
                    "filter[is_expired]": true,
                    per_page: 5,
                    page: data.selected + 1,
                    sort: "end_date",
                    direction: "desc",
                },
            })
        );

        setIsPaginated(true);

        return null;
    };

    useEffect(() => {
        if (isPaginated) {
            window.scrollTo({
                top:
                    (h2Ref.current !== null
                        ? h2Ref.current.getBoundingClientRect().top
                        : 0) +
                    window.pageYOffset +
                    -headerHeight -
                    20,
                behavior: "smooth",
            });
        }
    }, [promos, isPaginated, headerHeight]);

    if (!promos.items.length) {
        return <></>;
    }

    return (
        <Element
            css={css({
                display: "flex",
                flexDirection: "column",
                justifyContent: "flex-start",
                margin: "20px 0px 0px",
                marginTop: "0px",
                padding: "0px",
                position: "initial",
            })}
        >
            <Element
                childRef={h2Ref}
                css={css({
                    margin: "20px 0",
                })}
            >
                <Text as="h2" size={3}>
                    {`Старые купоны и промокоды ${store.name}`}
                </Text>
            </Element>

            {promos.items.map((promo) => {
                return <Promo key={promo.id} promo={promo} />;
            })}

            {promos.pagination.pages > 1 ? (
                <Element
                    css={css({
                        width: "100%",
                        display: "flex",
                        justifyContent: "center",
                    })}
                >
                    <ReactPaginate
                        previousLabel="👈"
                        nextLabel="👉"
                        breakLabel="..."
                        breakClassName="Pagination__Break"
                        pageCount={promos.pagination.pages}
                        initialPage={promos.pagination.page - 1}
                        forcePage={promos.pagination.page - 1}
                        onPageChange={(data) => handlePageChange(data)}
                        marginPagesDisplayed={1}
                        pageRangeDisplayed={2}
                        containerClassName="Pagination"
                        activeClassName="Pagination__Active"
                        disabledClassName="Pagination__Disabled"
                        previousClassName="Pagination__Previous"
                        nextClassName="Pagination__Next"
                    />
                </Element>
            ) : null}
        </Element>
    );
};

const OldPromos = withTranslation("common")(Component);

export { OldPromos };
