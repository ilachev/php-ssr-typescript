<?php

declare(strict_types=1);

namespace App\ReadModel\Blog\Posts\Post;

use App\Model\Blog\Entity\Posts\Post\Comment\Status;
use App\ReadModel\Blog\Posts\Post\Filter\Filter;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PostFetcher
{
    public function __construct(
        private Connection $connection,
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
            ->from('blog_posts_posts')
            ->orderBy('date')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'posts.id',
                'posts.name',
                'posts.date',
                'posts.update_date',
                'posts.sort',
                'posts.status',
                'posts.slug',
                'posts.description',
                'post_logo.id AS post_logo_id',
                'post_logo.info_path AS post_logo_info_path',
                'post_logo.info_name AS post_logo_info_name',
                'categories.slug AS post_category_slug',
                'COUNT(post_comments.post_id) as comments_count',
                'TRIM(CONCAT(authors.name_first, \' \', authors.name_last)) AS author_name',
                'authors.email AS author_email',
            )
            ->from('blog_posts_posts', 'posts')
            ->join('posts', 'category_post', 'cp', 'posts.id = cp.post_id')
            ->leftJoin(
                'cp',
                'blog_categories_categories',
                'categories',
                'cp.category_id = categories.id',
            )
            ->leftJoin(
                'posts',
                'blog_posts_post_logos',
                'post_logo',
                'posts.id = post_logo.post_id'
            )
            ->leftJoin(
                'posts',
                'blog_authors',
                'authors',
                'posts.author_id = authors.id'
            )
            ->leftJoin(
                'posts',
                'blog_posts_post_comments',
                'post_comments',
                'posts.id = post_comments.post_id AND post_comments.status = :comments_status'
            )
        ;

        $qb->setParameter(':comments_status', Status::APPROVED);

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(p.name)', ':name'));
            $qb->setParameter(':name', '%'.mb_strtolower($filter->name).'%');
        }

        if ($filter->status) {
            $qb->andWhere('posts.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if ($filter->category) {
            $qb->andWhere('categories.slug = :slug');
            $qb->setParameter(':slug', $filter->category);
        }

        if (!\in_array($sort, ['name', 'date', 'sort', 'status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by '.$sort);
        }

        $qb->orderBy($sort, 'desc' === $direction ? 'desc' : 'asc');
        $qb->groupBy('posts.id, post_logo.id, categories.slug, authors.name_first, authors.name_last, authors.email');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
