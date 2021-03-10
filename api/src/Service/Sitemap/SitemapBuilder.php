<?php

declare(strict_types=1);

namespace App\Service\Sitemap;

use App\ReadModel\Blog\Categories\Category\CategoryFetcher as BlogCategoryFetcher;
use App\ReadModel\Blog\Categories\Category\Filter\Filter as BlogCategoryFilter;
use App\ReadModel\Blog\Posts\Post\Filter\Filter as BlogPostFilter;
use App\ReadModel\Blog\Posts\Post\PostFetcher as BlogPostFetcher;
use App\ReadModel\Market\Categories\Category\CategoryFetcher as MarketCategoryFetcher;
use App\ReadModel\Market\Categories\Category\Filter\Filter as MarketCategoryFilter;
use App\ReadModel\Market\Stores\Store\Filter\Filter as MarketStoreFilter;
use App\ReadModel\Market\Stores\Store\StoreFetcher as MarketStoreFetcher;
use App\Service\FrontendUrlBuilder;
use App\Service\Pagination;
use DateTimeImmutable;
use JetBrains\PhpStorm\ArrayShape;

class SitemapBuilder
{
    public const ALWAYS = 'always';
    public const HOURLY = 'hourly';
    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const MONTHLY = 'monthly';
    public const YEARLY = 'yearly';
    public const NEVER = 'never';

    public function __construct(
        private FrontendUrlBuilder $urlBuilder,
        private BlogCategoryFetcher $blogCategories,
        private BlogPostFetcher $posts,
        private MarketCategoryFetcher $marketCategories,
        private MarketStoreFetcher $marketStores,
    ) {
    }

    public function getSitemapData(): array
    {
        return [
            $this->buildPages(self::WEEKLY, 0.5),
            $this->buildBlogCategories(self::WEEKLY, 0.5),
            $this->buildBlogPosts(self::DAILY, 0.8),
            $this->buildMarketCategories(self::WEEKLY, 0.5),
            $this->buildMarketStores(self::DAILY, 0.8),
        ];
    }

    #[ArrayShape(['name' => 'string', 'data' => 'array'])]
    private function buildPages(string $changeFreq, float $priority): array
    {
        $marketCategory = $this->marketCategories->last();
        $store = $this->marketStores->last();

        return [
            'name' => 'pages_sitemap.xml',
            'data' => [
                [
                    'loc' => $this->urlBuilder->generate(''),
                    'lastmod' => max($marketCategory->getDate(), $store->getDate())
                        ->format(DATE_ATOM),
                    'changefreq' => self::WEEKLY,
                    'priority' => 0.5,
                ],
                [
                    'loc' => $this->urlBuilder->generate('categories'),
                    'lastmod' => $marketCategory->getDate()->format(DATE_ATOM),
                    'changefreq' => self::WEEKLY,
                    'priority' => 0.2,
                ],
                [
                    'loc' => $this->urlBuilder->generate('stores'),
                    'lastmod' => $store->getDate()->format(DATE_ATOM),
                    'changefreq' => self::WEEKLY,
                    'priority' => 0.2,
                ],
            ],
        ];
    }

    #[ArrayShape(['name' => 'string', 'data' => 'array'])]
    private function buildBlogPosts(string $changeFreq, float $priority): array
    {
        $posts = [];
        $filter = BlogPostFilter::all();
        $page = 1;
        do {
            $pagination = $this->posts->all(
                $filter,
                $page,
                50,
                'date',
                'desc',
            );
            $posts[] = array_map(function (array $elem) use ($changeFreq, $priority) {
                return [
                    'loc' => $this->urlBuilder->generate(sprintf(
                        '%s/%s',
                        $elem['post_category_slug'],
                        $elem['slug'],
                    )),
                    'lastmod' => (new DateTimeImmutable($elem['update_date'] ?? $elem['date']))
                        ->format(DATE_ATOM),
                    'changefreq' => $changeFreq,
                    'priority' => $priority,
                ];
            }, (array) $pagination->getItems());
            ++$page;
        } while (Pagination::isNotLastPage($pagination));

        return [
            'name' => 'blog_posts_sitemap.xml',
            'data' => array_merge([], ...$posts),
        ];
    }

    #[ArrayShape(['name' => 'string', 'data' => 'array'])]
    private function buildBlogCategories(string $changeFreq, float $priority): array
    {
        $posts = [];
        $filter = BlogCategoryFilter::all();
        $page = 1;
        do {
            $pagination = $this->blogCategories->all(
                $filter,
                $page,
                50,
                'date',
                'desc',
            );
            $posts[] = array_map(function (array $elem) use ($changeFreq, $priority) {
                return [
                    'loc' => $this->urlBuilder->generate(sprintf(
                        'blog/%s',
                        $elem['slug'],
                    )),
                    'lastmod' => (new DateTimeImmutable($elem['update_date'] ?? $elem['date']))
                        ->format(DATE_ATOM),
                    'changefreq' => $changeFreq,
                    'priority' => $priority,
                ];
            }, (array) $pagination->getItems());
            ++$page;
        } while (Pagination::isNotLastPage($pagination));

        return [
            'name' => 'blog_categories_sitemap.xml',
            'data' => array_merge([], ...$posts),
        ];
    }

    #[ArrayShape(['name' => 'string', 'data' => 'array'])]
    private function buildMarketStores(string $changeFreq, float $priority): array
    {
        $posts = [];
        $filter = MarketStoreFilter::all();
        $page = 1;
        do {
            $pagination = $this->marketStores->all(
                $filter,
                $page,
                50,
                'date',
                'desc',
            );
            $posts[] = array_map(function (array $elem) use ($changeFreq, $priority) {
                return [
                    'loc' => $this->urlBuilder->generate(sprintf(
                        'stores/%s',
                        $elem['slug'],
                    )),
                    'lastmod' => (new DateTimeImmutable($elem['update_date'] ?? $elem['date']))
                        ->format(DATE_ATOM),
                    'changefreq' => $changeFreq,
                    'priority' => $priority,
                ];
            }, (array) $pagination->getItems());
            ++$page;
        } while (Pagination::isNotLastPage($pagination));

        return [
            'name' => 'market_stores_sitemap.xml',
            'data' => array_merge([], ...$posts),
        ];
    }

    #[ArrayShape(['name' => 'string', 'data' => 'array'])]
    private function buildMarketCategories(string $changeFreq, float $priority): array
    {
        $posts = [];
        $filter = MarketCategoryFilter::all();
        $filter->withStores = 'true';
        $page = 1;
        do {
            $pagination = $this->marketCategories->all(
                $filter,
                $page,
                50,
                'date',
                'desc',
            );
            $posts[] = array_map(function (array $elem) use ($changeFreq, $priority) {
                return [
                    'loc' => $this->urlBuilder->generate(sprintf(
                        'categories/%s',
                        $elem['slug'],
                    )),
                    'lastmod' => (new DateTimeImmutable($elem['update_date'] ?? $elem['date']))
                        ->format(DATE_ATOM),
                    'changefreq' => $changeFreq,
                    'priority' => $priority,
                ];
            }, (array) $pagination->getItems());
            ++$page;
        } while (Pagination::isNotLastPage($pagination));

        return [
            'name' => 'market_categories_sitemap.xml',
            'data' => array_merge([], ...$posts),
        ];
    }
}
