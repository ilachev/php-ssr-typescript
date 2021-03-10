<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Stores\Comments;

use App\Model\EntityNotFoundException;
use App\Model\Market\Entity\Author\AuthorRepository;
use App\Model\Market\Entity\Author\Id;
use App\Model\Market\Entity\Stores\Store\Comment\Status;
use App\ReadModel\Market\Stores\Comments\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;

class CommentsFetcher
{
    public function __construct(
        private Connection $connection,
        private EntityManagerInterface $em,
        private PaginatorInterface $paginator,
        private Security $auth,
        private AuthorRepository $authors,
    ) {
    }

    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'c.id',
                'c.date',
                'c.status',
                'c.text',
                's.id store_id',
                's.name store_name',
                'a.id author_id',
                'TRIM(CONCAT(a.name_first, \' \', a.name_last)) AS author_name',
            )
            ->from('market_stores_store_comments', 'c')
            ->leftJoin('c', 'market_stores_stores', 's', 'c.store_id = s.id')
            ->leftJoin('c', 'market_authors', 'a', 'c.author_id = a.id')
        ;

        if ($filter->status) {
            $qb->andWhere('c.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if ($filter->slug) {
            $qb->andWhere($qb->expr()->like('LOWER(s.name)', ':store_name'));
            $qb->setParameter(':store_name', '%'.mb_strtolower($filter->slug).'%');
        }

        if (!\in_array($sort, ['date', 'status', 'store_name'], true)) {
            throw new \UnexpectedValueException('Cannot sort by '.$sort);
        }

        $qb->orderBy($sort, 'desc' === $direction ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function allTree(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $author = null;

        try {
            if ($id = $this->auth->getUser()?->getId()) {
                $author = $this->authors->get(new Id($id));
            }
        } catch (EntityNotFoundException) {
            $author = null;
        }

        $rsm = (new ResultSetMapping())
            ->addScalarResult('id', 'id')
            ->addScalarResult('text', 'text')
            ->addScalarResult('level', 'level')
            ->addScalarResult('parent_id', 'parent_id')
            ->addScalarResult('author_id', 'author_id')
            ->addScalarResult('author_name', 'author_name')
            ->addScalarResult('author_email', 'author_email')
            ->addScalarResult('user_role', 'user_role')
            ->addScalarResult('date', 'date')
        ;

        $wherePart = "s.slug = '".$filter->slug."'";
        $wherePart .= null === $author ?
            "AND (t.status = '".Status::APPROVED."')" :
            "AND (t.status = '".Status::APPROVED."' OR t.author_id = '".$author->getId()->getValue()."')";

        $qb = $this->em->createNativeQuery(<<<SQL

            WITH RECURSIVE tree (id, text, level, parent_id, author_id, store_id, date) AS (
                SELECT
                    c.id,
                    c.text,
                    1,
                    c.parent_id,
                    c.author_id,
                    c.store_id,
                    c.date,
                    c.status
                FROM market_stores_store_comments c
                WHERE parent_id IS NULL
            
                UNION ALL
            
                SELECT
                    c.id,
                    c.text,
                    t.level + 1,
                    t.id,
                    c.author_id,
                    c.store_id,
                    c.date,
                    c.status
                FROM market_stores_store_comments c, tree t
                WHERE c.parent_id = t.id
            )
            SELECT 
                   t.id, 
                   t.text, 
                   t.level, 
                   t.parent_id, 
                   t.author_id, 
                   t.store_id, 
                   t.date, 
                   TRIM(CONCAT(ma.name_first, ' ', ma.name_last)) AS author_name,
                   ma.email as author_email,
                   u.role as user_role
            FROM tree t
                LEFT JOIN market_authors ma ON t.author_id = ma.id
                LEFT JOIN market_stores_stores s ON t.store_id = s.id
                LEFT JOIN user_users u ON t.author_id = u.id
            WHERE {$wherePart} ::parent:: ::ids::
            ORDER BY t.date DESC
            LIMIT :limit
            OFFSET :offset
        
        SQL
        , $rsm);

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function allCount(Filter $filter)
    {
        $author = null;

        try {
            if ($id = $this->auth->getUser()?->getId()) {
                $author = $this->authors->get(new Id($id));
            }
        } catch (EntityNotFoundException) {
            $author = null;
        }

        $qb = $this->connection->createQueryBuilder()
            ->select(
                'COUNT(c.id)',
            )
            ->from('market_stores_store_comments', 'c')
            ->leftJoin('c', 'market_stores_stores', 's', 'c.store_id = s.id')
        ;

        if ($filter->slug) {
            $qb->andWhere('s.slug = :slug');
            $qb->setParameter(':slug', $filter->slug);
        }

        if (null === $author) {
            $qb->andWhere('c.status = :status');
            $qb->setParameter(':status', Status::APPROVED);
        } else {
            $qb->andWhere(
                $qb->expr()->or(
                    'c.status = :status',
                    'c.author_id = :author'
                ),
            );
            $qb->setParameter(':status', Status::APPROVED);
            $qb->setParameter(':author', $author->getId()->getValue());
        }

        return $qb->execute()->fetchAllAssociative();
    }
}
