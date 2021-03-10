<?php

declare(strict_types=1);

namespace App\DataFixtures\Market\Categories;

use App\DataFixtures\Market\Author\AuthorFixture;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Categories\Category\Category;
use App\Model\Market\Entity\Categories\Category\Id;
use App\Model\Market\Entity\Categories\Category\Logo\Id as LogoId;
use App\Model\Market\Entity\Categories\Category\Logo\Info as LogoInfo;
use App\Model\Market\Entity\Categories\Category\Logo\Logo;
use App\Model\Market\Entity\Categories\Category\Seo;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixture extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE_CLOTHES = 'clothes';
    public const REFERENCE_PHONES = 'phones';
    public const REFERENCE_BEAUTY = 'beauty';
    public const REFERENCE_GAMES = 'games';
    public const REFERENCE_HOME = 'home';
    public const REFERENCE_SPORT = 'sport';
    public const REFERENCE_PET = 'pet';

    private const CATEGORIES = [
        [
            'name' => 'Одежда и обувь',
            'sort' => 0,
            'logoName' => 'clothes.png',
            'ref' => self::REFERENCE_CLOTHES,
        ],
        [
            'name' => 'Телефоны и аксессуары',
            'sort' => 1,
            'logoName' => 'phones.png',
            'ref' => self::REFERENCE_PHONES,
        ],
        [
            'name' => 'Красота и уход за здоровьем',
            'sort' => 2,
            'logoName' => 'beauty.png',
            'ref' => self::REFERENCE_BEAUTY,
        ],
        [
            'name' => 'Игры',
            'sort' => 3,
            'logoName' => 'games.png',
            'ref' => self::REFERENCE_GAMES,
        ],
        [
            'name' => 'Дом и кухня',
            'sort' => 4,
            'logoName' => 'home.png',
            'ref' => self::REFERENCE_HOME,
        ],
        [
            'name' => 'Спорт',
            'sort' => 5,
            'logoName' => 'sport.jpeg',
            'ref' => self::REFERENCE_SPORT,
        ],
        [
            'name' => 'Товары для питомцев',
            'sort' => 6,
            'logoName' => 'pet.png',
            'ref' => self::REFERENCE_PET,
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
                $data['sort'],
                $data['logoName']
            );
            $manager->persist($store);
            $this->setReference($data['ref'], $store);
        }

        $manager->flush();
    }

    private function createCategory(
        Author $author,
        string $name,
        int $sort,
        string $logoName
    ): Category {
        $category = new Category(
            Id::next(),
            $author,
            $name,
            new DateTimeImmutable(),
            $this->slugger->slug($name)->lower()->toString(),
            new Seo(),
            $sort
        );

        $category->setLogo(
            new Logo(
                LogoId::next(),
                $category,
                new LogoInfo(
                    'fixtures/categories',
                    $logoName,
                    1
                ),
                new DateTimeImmutable()
            )
        );

        return $category;
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixture::class,
        ];
    }
}
