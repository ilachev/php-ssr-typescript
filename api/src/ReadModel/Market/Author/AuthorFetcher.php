<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Author;

use App\Model\Market\Entity\Author\Author;
use App\ReadModel\Market\Author\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use function in_array;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use UnexpectedValueException;

class AuthorFetcher
{
    private Connection $connection;
    private PaginatorInterface $paginator;
    private ObjectRepository $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Author::class);
        $this->paginator = $paginator;
    }

    public function find(string $id): ?Author
    {
        return $this->repository->find($id);
    }

    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'a.id',
                'TRIM(CONCAT(a.name_first, \' \', a.name_last)) AS name',
                'a.email',
                'a.status',
                'a.date'
            )
            ->from('market_authors', 'a');

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(CONCAT(a.name_first, \' \', a.name_last))', ':name'));
            $qb->setParameter(':name', '%'.mb_strtolower($filter->name).'%');
        }

        if ($filter->email) {
            $qb->andWhere($qb->expr()->like('LOWER(a.email)', ':email'));
            $qb->setParameter(':email', '%'.mb_strtolower($filter->email).'%');
        }

        if ($filter->status) {
            $qb->andWhere('a.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if (!in_array($sort, ['name', 'email', 'status'], true)) {
            throw new UnexpectedValueException('Cannot sort by '.$sort);
        }

        $qb->orderBy($sort, 'desc' === $direction ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('market_authors')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }
}
