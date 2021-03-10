<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Promos\Promo;

use App\ReadModel\Market\Promos\Promo\Filter\Filter;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PromoFetcher
{
    private Connection $connection;
    private PaginatorInterface $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('market_promos_promos')
            ->orderBy('date')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'p.id',
                'p.name',
                'p.type',
                'p.discount',
                'p.discount_unit',
                'p.description',
                'p.date',
                'p.start_date',
                'p.end_date',
                'p.status',
                'p.code',
                's.id AS store_id',
                's.name AS store_name',
                'l.internal_id AS referral',
            )
            ->from('market_promos_promos', 'p')
            ->leftJoin('p', 'market_stores_stores', 's', 'p.store_id = s.id')
            ->join('p', 'market_promos_promo_referral_links', 'l', 'p.id = l.promo_id')
        ;

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(p.name)', ':name'));
            $qb->setParameter(':name', '%'.mb_strtolower($filter->name).'%');
        }

        if ($filter->slug) {
            $qb->andWhere('s.slug = :slug');
            $qb->setParameter(':slug', $filter->slug);
        }

        if ($filter->type && 'all' !== $filter->type) {
            $qb->andWhere('type = :type');
            $qb->setParameter(':type', $filter->type);
        }

        if ($filter->status) {
            $qb->andWhere('p.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if ($filter->store) {
            $qb->andWhere($qb->expr()->like('LOWER(s.name)', ':store_name'));
            $qb->setParameter(':store_name', '%'.mb_strtolower($filter->store).'%');
        }

        $isExpired = null;
        if (null !== $filter->isExpired) {
            $isExpired = filter_var($filter->isExpired, FILTER_VALIDATE_BOOLEAN);
        }

        if (true === $isExpired) {
            $qb->andWhere('p.end_date < NOW()');
        } elseif (false === $isExpired) {
            $qb->andWhere('p.end_date > NOW()');
        }

        if (!\in_array($sort, ['name', 'date', 'type', 'status', 'store_name', 'end_date'], true)) {
            throw new \UnexpectedValueException('Cannot sort by '.$sort);
        }

        $qb->orderBy($sort, 'desc' === $direction ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function allCount(Filter $filter): array
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'COUNT(p.id)',
                'p.type'
            )
            ->from('market_promos_promos', 'p')
            ->leftJoin('p', 'market_stores_stores', 's', 'p.store_id = s.id')
            ->join('p', 'market_promos_promo_referral_links', 'l', 'p.id = l.promo_id')
        ;

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(p.name)', ':name'));
            $qb->setParameter(':name', '%'.mb_strtolower($filter->name).'%');
        }

        if ($filter->slug) {
            $qb->andWhere('s.slug = :slug');
            $qb->setParameter(':slug', $filter->slug);
        }

        if ($filter->type) {
            $qb->andWhere('type = :type');
            $qb->setParameter(':type', $filter->type);
        }

        if ($filter->status) {
            $qb->andWhere('p.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if ($filter->store) {
            $qb->andWhere($qb->expr()->like('LOWER(s.name)', ':store_name'));
            $qb->setParameter(':store_name', '%'.mb_strtolower($filter->store).'%');
        }

        $isExpired = filter_var($filter->isExpired, FILTER_VALIDATE_BOOLEAN);

        if (true === $isExpired) {
            $qb->andWhere('p.end_date < NOW()');
        } elseif (false === $isExpired) {
            $qb->andWhere('p.end_date > NOW()');
        }

        $qb->groupBy('p.type');

        return $qb->execute()->fetchAllAssociative();
    }
}
