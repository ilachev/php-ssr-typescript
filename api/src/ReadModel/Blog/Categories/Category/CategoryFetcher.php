<?php

declare(strict_types=1);

namespace App\ReadModel\Blog\Categories\Category;

use App\ReadModel\Blog\Categories\Category\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class CategoryFetcher
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
            ->from('blog_categories_categories')
            ->orderBy('date')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'c.id',
                'c.name',
                'c.date',
                'c.update_date',
                'c.sort',
                'c.status',
                'c.slug',
            )
            ->from('blog_categories_categories', 'c')
        ;

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(c.name)', ':name'));
            $qb->setParameter(':name', '%'.mb_strtolower($filter->name).'%');
        }

        if ($filter->status) {
            $qb->andWhere('c.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if (!\in_array($sort, ['name', 'date', 'sort', 'status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by '.$sort);
        }

        $qb->orderBy($sort, 'desc' === $direction ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
