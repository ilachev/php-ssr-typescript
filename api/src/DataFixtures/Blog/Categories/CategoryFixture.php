<?php

declare(strict_types=1);

namespace App\DataFixtures\Blog\Categories;

use App\DataFixtures\Blog\Author\AuthorFixture;
use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Categories\Category\Category;
use App\Model\Blog\Entity\Categories\Category\Id;
use App\Model\Blog\Entity\Categories\Category\Meta;
use App\Model\Blog\Entity\Categories\Category\Seo;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixture extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE_NEWS = 'blog_category_news';
    public const REFERENCE_HELP = 'blog_category_help';

    private const CATEGORIES = [
        [
            'name' => 'Новости',
            'sort' => 0,
            'ref' => self::REFERENCE_NEWS,
        ],
        [
            'name' => 'Помощь',
            'sort' => 1,
            'ref' => self::REFERENCE_HELP,
        ],
    ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        /**
         * @var Author $author
         */
        $author = $this->getReference(AuthorFixture::REFERENCE_ADMIN);
        foreach (self::CATEGORIES as $data) {
            $store = $this->createCategory(
                $author,
                $data['name'],
                $data['sort']
            );
            $manager->persist($store);
            $this->setReference($data['ref'], $store);
        }

        $manager->flush();
    }

    private function createCategory(
        Author $author,
        string $name,
        int $sort
    ): Category {
        return new Category(
            Id::next(),
            $author,
            $name,
            new DateTimeImmutable(),
            $this->slugger->slug($name)->lower()->toString(),
            new Seo(),
            new Meta(),
            $sort
        );
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixture::class,
        ];
    }
}
