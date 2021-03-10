// #region Global Imports
import { FunctionComponent, useEffect, useRef, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import css from "@styled-system/css";
import ReactPaginate from "react-paginate";
// #endregion Global Imports

// #region Local Imports
import { Promo } from "@Components/Promo";
import { Element } from "@Components/Basic";
import { withTranslation } from "@Server/i18n";
import { StoreActions } from "@Actions";
// #endregion Local Imports

// #region Interface Imports
import { IStore } from "@Redux/IStore";
import { IPromos } from "./Promos";
// #endregion Interface Imports

const Component: FunctionComponent<IPromos.IProps> = (): JSX.Element => {
    const promos = useSelector((state: IStore) => state.Store.promos);
    const store = useSelector((state: IStore) => state.Store.store);
    const activePromoType = useSelector(
        (state: IStore) => state.Store.activePromoType
    );
    const headerHeight = useSelector((state: IStore) => state.Header.height);
    const dispatch = useDispatch();

    const [isPaginated, setIsPaginated] = useState(false);

    const h2Ref = useRef<HTMLElement>(null);

    const handlePageChange = (data) => {
        if (data.selected + 1 === promos.pagination.page) {
            return null;
        }

        const curPage = data.selected + 1;

        dispatch(
            StoreActions.GetPromos({
                params: {
                    "filter[slug]": store.slug,
                    "filter[type]": activePromoType,
                    "filter[is_expired]": false,
                    per_page: 10,
                    page: curPage,
                    sort: "end_date",
                    direction: "asc",
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
            childRef={h2Ref}
        >
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

const Promos = withTranslation("common")(Component);

export { Promos };
