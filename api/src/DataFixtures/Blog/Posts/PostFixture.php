<?php

declare(strict_types=1);

namespace App\DataFixtures\Blog\Posts;

use App\DataFixtures\Blog\Author\AuthorFixture;
use App\DataFixtures\Blog\Categories\CategoryFixture;
use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Categories\Category\Category;
use App\Model\Blog\Entity\Posts\Post\Id;
use App\Model\Blog\Entity\Posts\Post\Logo\Id as LogoId;
use App\Model\Blog\Entity\Posts\Post\Logo\Info as LogoInfo;
use App\Model\Blog\Entity\Posts\Post\Logo\Logo;
use App\Model\Blog\Entity\Posts\Post\Meta;
use App\Model\Blog\Entity\Posts\Post\Post;
use App\Model\Blog\Entity\Posts\Post\Seo;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostFixture extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE_NEWS_CIANAO_1 = 'blog_news_cianao_1';
    public const REFERENCE_NEWS_CIANAO_2 = 'blog_news_cianao_2';
    public const REFERENCE_NEWS_CIANAO_3 = 'blog_news_cianao_3';
    public const REFERENCE_HELP_PAYMENT = 'blog_help_payment';

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getPostsData() as $data) {
            $post = $this->createPost(
                $data['author'],
                $data['category'],
                $data['name'],
                $data['metaTitle'],
                $data['metaDescription'],
                $data['sort'],
                $data['description'],
                $data['logoName'],
            );
            $manager->persist($post);
            $this->setReference($data['ref'], $post);
        }

        $manager->flush();
    }

    private function createPost(
        Author $author,
        Category $category,
        string $name,
        string $metaTitle,
        string $metaDescription,
        int $sort,
        string $description,
        string $logoName,
    ): Post {
        $post = new Post(
            Id::next(),
            $author,
            $name,
            new DateTimeImmutable(),
            $this->slugger->slug($name)->lower()->toString(),
            new Seo(),
            new Meta($metaTitle, $metaDescription),
            $sort,
            $description
        );

        $post->setLogo(
            new Logo(
                LogoId::next(),
                $post,
                new LogoInfo(
                    'fixtures/blog',
                    $logoName,
                    1
                ),
                new DateTimeImmutable(),
            )
        );

        $post->addCategory($category);
        $category->addPost($post);

        return $post;
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixture::class,
            CategoryFixture::class,
        ];
    }

    private function getPostsData(): array
    {
        /** @var Author $author */
        $author = $this->getReference(AuthorFixture::REFERENCE_ADMIN);
        /** @var Category $newsCategory */
        $newsCategory = $this->getReference(CategoryFixture::REFERENCE_NEWS);
        /** @var Category $helpCategory */
        $helpCategory = $this->getReference(CategoryFixture::REFERENCE_HELP);

        return [
            [
                'name' => 'Постаматы Cianao в России 1',
                'category' => $newsCategory,
                'author' => $author,
                'ref' => self::REFERENCE_NEWS_CIANAO_1,
                'description' => '<p>Приобрести товары с AliExpress стало еще проще. В конце 2020 года логистическая компания Cainiao запустила первый в России офлайн-проект &mdash; собственную сеть постаматов для доставки заказов с AliExpress. Данное нововведение было приурочено к всемирному дню шоппинга 11 ноября.</p>

<p>Россия является первой и единственной страной, где существует данная услуга доставки. Руководитель по стратегическому развитию постаматной сети &laquo;Cainiao&raquo; в России - Ксения Киянцева отмечает, что компания планирует открыть более 1&nbsp;000 пунктов выдачи по всей России. Однако, на данный момент, постаматы Цайняо реализованы только в Москве и Московской области.</p>

<p>Новая сеть точек доставки заказов является хорошей альтернативой для получения товаров с AliExpress. Это может способствовать улучшению логистики для продавцов и более комфортному шоппингу для покупателей.</p>

<h2><strong>Постаматы Cainiao в Москве</strong></h2>


<p>Возможно, один из адресов подойдет вам для комфортного получения вашего заказа:</p>

<ol>
	<li>Открытое шоссе, 17 к4. График работы: ежедневно с 08:00 до 23:00</li>
	<li>Мира проспект, 95 ст2. График работы: круглосуточно</li>
	<li>Байкальская, 40/17. График работы: ежедневно с 09:00 до 22:00</li>
	<li>Парковая 3-я, 53. График работы: ежедневно с 08:00 до 23:00</li>
	<li>ТЦ Тимирязевский. График работы: ежедневно с 10:00 до 21:00</li>
	<li>Владимирская 2-я, 32 к1</li>
	<li>Берёзовая аллея, 17 к2. График работы: ежедневно с 08:00 до 22:00</li>
	<li>Лётчика Бабушкина, 30 ст1. График работы: ежедневно с 08:00 до 21:00</li>
	<li>Инженерная, 15. График работы: ежедневно с 08:00 до 23:00</li>
	<li>Дубнинская, 36. График работы: ежедневно с 09:00 до 21:00</li>
</ol>',
                'sort' => 0,
                'metaTitle' => 'Постаматы Cianao – адреса филиалов на карте',
                'metaDescription' => 'Полный список адресов постаматов Cianao в Москве. Здесь вы можете найти список всех постаматов Цайняо по Москве, СПб и других городах России.',
                'logoName' => 'cianao.jpg',
            ],
            [
                'name' => 'Постаматы Cianao в России 2',
                'category' => $newsCategory,
                'author' => $author,
                'ref' => self::REFERENCE_NEWS_CIANAO_2,
                'description' => '<p>Приобрести товары с AliExpress стало еще проще. В конце 2020 года логистическая компания Cainiao запустила первый в России офлайн-проект &mdash; собственную сеть постаматов для доставки заказов с AliExpress. Данное нововведение было приурочено к всемирному дню шоппинга 11 ноября.</p>

<p>Россия является первой и единственной страной, где существует данная услуга доставки. Руководитель по стратегическому развитию постаматной сети &laquo;Cainiao&raquo; в России - Ксения Киянцева отмечает, что компания планирует открыть более 1&nbsp;000 пунктов выдачи по всей России. Однако, на данный момент, постаматы Цайняо реализованы только в Москве и Московской области.</p>

<p>Новая сеть точек доставки заказов является хорошей альтернативой для получения товаров с AliExpress. Это может способствовать улучшению логистики для продавцов и более комфортному шоппингу для покупателей.</p>

<h2><strong>Постаматы Cainiao в Москве</strong></h2>


<p>Возможно, один из адресов подойдет вам для комфортного получения вашего заказа:</p>

<ol>
	<li>Открытое шоссе, 17 к4. График работы: ежедневно с 08:00 до 23:00</li>
	<li>Мира проспект, 95 ст2. График работы: круглосуточно</li>
	<li>Байкальская, 40/17. График работы: ежедневно с 09:00 до 22:00</li>
	<li>Парковая 3-я, 53. График работы: ежедневно с 08:00 до 23:00</li>
	<li>ТЦ Тимирязевский. График работы: ежедневно с 10:00 до 21:00</li>
	<li>Владимирская 2-я, 32 к1</li>
	<li>Берёзовая аллея, 17 к2. График работы: ежедневно с 08:00 до 22:00</li>
	<li>Лётчика Бабушкина, 30 ст1. График работы: ежедневно с 08:00 до 21:00</li>
	<li>Инженерная, 15. График работы: ежедневно с 08:00 до 23:00</li>
	<li>Дубнинская, 36. График работы: ежедневно с 09:00 до 21:00</li>
</ol>',
                'sort' => 0,
                'metaTitle' => 'Постаматы Cianao – адреса филиалов на карте',
                'metaDescription' => 'Полный список адресов постаматов Cianao в Москве. Здесь вы можете найти список всех постаматов Цайняо по Москве, СПб и других городах России.',
                'logoName' => 'cianao.jpg',
            ],
            [
                'name' => 'Постаматы Cianao в России 3',
                'category' => $newsCategory,
                'author' => $author,
                'ref' => self::REFERENCE_NEWS_CIANAO_3,
                'description' => '<p>Приобрести товары с AliExpress стало еще проще. В конце 2020 года логистическая компания Cainiao запустила первый в России офлайн-проект &mdash; собственную сеть постаматов для доставки заказов с AliExpress. Данное нововведение было приурочено к всемирному дню шоппинга 11 ноября.</p>

<p>Россия является первой и единственной страной, где существует данная услуга доставки. Руководитель по стратегическому развитию постаматной сети &laquo;Cainiao&raquo; в России - Ксения Киянцева отмечает, что компания планирует открыть более 1&nbsp;000 пунктов выдачи по всей России. Однако, на данный момент, постаматы Цайняо реализованы только в Москве и Московской области.</p>

<p>Новая сеть точек доставки заказов является хорошей альтернативой для получения товаров с AliExpress. Это может способствовать улучшению логистики для продавцов и более комфортному шоппингу для покупателей.</p>

<h2><strong>Постаматы Cainiao в Москве</strong></h2>


<p>Возможно, один из адресов подойдет вам для комфортного получения вашего заказа:</p>

<ol>
	<li>Открытое шоссе, 17 к4. График работы: ежедневно с 08:00 до 23:00</li>
	<li>Мира проспект, 95 ст2. График работы: круглосуточно</li>
	<li>Байкальская, 40/17. График работы: ежедневно с 09:00 до 22:00</li>
	<li>Парковая 3-я, 53. График работы: ежедневно с 08:00 до 23:00</li>
	<li>ТЦ Тимирязевский. График работы: ежедневно с 10:00 до 21:00</li>
	<li>Владимирская 2-я, 32 к1</li>
	<li>Берёзовая аллея, 17 к2. График работы: ежедневно с 08:00 до 22:00</li>
	<li>Лётчика Бабушкина, 30 ст1. График работы: ежедневно с 08:00 до 21:00</li>
	<li>Инженерная, 15. График работы: ежедневно с 08:00 до 23:00</li>
	<li>Дубнинская, 36. График работы: ежедневно с 09:00 до 21:00</li>
</ol>',
                'sort' => 0,
                'metaTitle' => 'Постаматы Cianao – адреса филиалов на карте',
                'metaDescription' => 'Полный список адресов постаматов Cianao в Москве. Здесь вы можете найти список всех постаматов Цайняо по Москве, СПб и других городах России.',
                'logoName' => 'cianao.jpg',
            ],

            [
                'name' => 'Таможенная пошлина в 2021 году на Алиэкспресс',
                'category' => $helpCategory,
                'author' => $author,
                'ref' => self::REFERENCE_HELP_PAYMENT,
                'description' => '<p>В 2020 года снизился лимит беспошлинного ввоза на товары AliExpress в Россию. Ранее сумма покупки которая облагалась пошлиной составляла 500 евро. На момент 2020 года сумма уменьшилась до 200 €. Однако, не все так плохо как можно подумать, сам процесс налогообложения также меняется.</p>',
                'sort' => 0,
                'metaTitle' => 'Таможенная пошлина в 2021 году на Алиэкспресс',
                'metaDescription' => 'Таможенная пошлина в 2021 году на Алиэкспресс.',
                'logoName' => 'custody.jpg',
            ],
        ];
    }
}
