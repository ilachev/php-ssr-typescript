<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Categories\Category;

use App\Model\EntityNotFoundException;
use App\Model\Market\Entity\Categories\Category\Category;
use App\ReadModel\Market\Categories\Category\Filter\Filter;
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
            ->from('market_categories_categories')
            ->orderBy('date')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'DISTINCT c.id',
                'c.name',
                'c.date',
                'c.sort',
                'c.status',
                'c.slug',
                'category_logo.id as category_logo_id',
                'category_logo.info_path as category_logo_info_path',
                'category_logo.info_name as category_logo_info_name',
            )
            ->from('market_categories_categories', 'c')
            ->leftJoin(
                'c',
                'market_categories_category_logos',
                'category_logo',
                'c.id = category_logo.category_id'
            )
        ;

        if ($filter->withStores) {
            $qb->join('c', 'category_store', 'cs', 'c.id = cs.category_id');
            $qb->leftJoin(
                'cs',
                'market_stores_stores',
                's',
                'cs.store_id = s.id',
            );
        }

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

    public function last(): Category
    {
        $categories = $this->em->getRepository(Category::class)->findBy([], ['date' => 'desc'], 1);

        if (0 === count($categories)) {
            throw new EntityNotFoundException('Категория не найдена');
        }

        return array_values($categories)[0];
    }
}
