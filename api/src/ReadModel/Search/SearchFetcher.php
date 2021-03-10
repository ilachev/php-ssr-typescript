<?php

declare(strict_types=1);

namespace App\ReadModel\Search;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class SearchFetcher
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function all(Filter $filter): array
    {
        if (!$filter->q) {
            return [];
        }

        $rsm = (new ResultSetMapping())
            ->addScalarResult('id', 'id')
            ->addScalarResult('name', 'name')
            ->addScalarResult('slug', 'slug')
            ->addScalarResult('category', 'category')
            ->addScalarResult('type', 'type')
        ;

        $qb = $this->em->createNativeQuery(<<<SQL

            SELECT id, name, slug, 'stores' as category, 'stores' AS type
            FROM market_stores_stores
            WHERE LOWER(name) LIKE LOWER(:store_q)
            
            UNION ALL
            
            SELECT p.id, p.name, p.slug, c.slug as category, 'posts' AS type
            FROM blog_posts_posts p
                INNER JOIN category_post cp ON p.id = cp.post_id
                LEFT JOIN blog_categories_categories c ON cp.category_id = c.id
            WHERE LOWER(p.description) LIKE LOWER(:post_q)
            
            LIMIT 6
        
        SQL
            , $rsm);
        $qb->setParameter(':store_q', trim($filter->q).'%');
        $qb->setParameter(':post_q', '%'.trim($filter->q).'%');

        return $qb->getArrayResult();
    }
}
