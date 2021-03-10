<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Stores\Store;

use App\Model\EntityNotFoundException;
use App\Model\Market\Entity\Stores\Store\Store;
use App\ReadModel\Market\Stores\Store\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class StoreFetcher
{
    public function __construct(
        private Connection $connection,
        private EntityManagerInterface $em,
        private PaginatorInterface $paginator,
    ) {
    }

    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('market_stores_stores')
            ->orderBy('date')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'DISTINCT s.id',
                's.name',
                's.date',
                's.update_date',
                's.sort',
                's.status',
                's.slug',
                'store_logo.id as store_logo_id',
                'store_logo.info_path as store_logo_info_path',
                'store_logo.info_name as store_logo_info_name',
            )
            ->from('market_stores_stores', 's')
            ->leftJoin(
                's',
                'market_stores_store_logos',
                'store_logo',
                's.id = store_logo.store_id'
            )
        ;

        if ($filter->category) {
            $qb->join('s', 'category_store', 'cs', 's.id = cs.store_id');
            $qb->leftJoin(
                'cs',
                'market_categories_categories',
                'c',
                'cs.category_id = c.id',
            );
            $qb->andWhere('c.slug = :category_slug');
            $qb->setParameter(':category_slug', $filter->category);
        }

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(s.name)', ':name'));
            $qb->setParameter(':name', '%'.mb_strtolower($filter->name).'%');
        }

        if ($filter->status) {
            $qb->andWhere('s.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if (!\in_array($sort, ['name', 'date', 'sort', 'status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by '.$sort);
        }

        $qb->orderBy($sort, 'desc' === $direction ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function last(): Store
    {
        $categories = $this->em->getRepository(Store::class)->findBy([], ['date' => 'desc'], 1);

        if (0 === count($categories)) {
            throw new EntityNotFoundException('Магазин не найден');
        }

        return array_values($categories)[0];
    }
}
