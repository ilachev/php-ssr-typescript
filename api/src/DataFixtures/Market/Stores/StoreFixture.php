<?php

declare(strict_types=1);

namespace App\DataFixtures\Market\Stores;

use App\DataFixtures\Market\Author\AuthorFixture;
use App\DataFixtures\Market\Categories\CategoryFixture;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Categories\Category\Category;
use App\Model\Market\Entity\Stores\Store\Id;
use App\Model\Market\Entity\Stores\Store\Info;
use App\Model\Market\Entity\Stores\Store\Logo\Id as LogoId;
use App\Model\Market\Entity\Stores\Store\Logo\Info as LogoInfo;
use App\Model\Market\Entity\Stores\Store\Logo\Logo;
use App\Model\Market\Entity\Stores\Store\Meta;
use App\Model\Market\Entity\Stores\Store\Seo;
use App\Model\Market\Entity\Stores\Store\Store;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class StoreFixture extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE_FIRST = 'first';
    public const REFERENCE_SECOND = 'second';
    public const REFERENCE_ADIDAS = 'adidas';

    private const CLOTHES_STORES = [
        [
            'name' => 'Zara',
            'sort' => 0,
            'logoName' => 'zara.jpg',
            'seoHeading' => 'Купоны зара в октябре 2021 года.',
            'seoDescription' => 'Здесь находится подборка таких купонов за этот год.',
            'metaTitle' => 'Купоны и купоны для зары',
            'metaDescription' => 'Купоны и купоны для зары такие классные и прекрасные',
            'metaOgTitle' => 'OG Купоны и купоны для зары',
            'metaOgDescription' => 'OG Купоны и купоны для зары такие классные и прекрасные',
        ],
        [
            'name' => 'Adidas',
            'sort' => 1,
            'logoName' => 'adidas.png',
            'description' => '<p>AliExpress - одна из самых популярных интернет-площадок Китая, входяшая в группу компаний Alibaba Group. В интернет-магазине представлен огромный ассортимент продукцию как продавцов из Китая, так и местных магазинов. Главным преимуществом Алиэкспресс является бесплатная доставка на товары любой ценовой категории. Несмотря на низкие цены. на площадке также представлено большое количество купонов и промокодов дающие дополнительную скидку.</p>',
            'info' => [
                'detail' => '<h2>Как на Алиэкспресс купить товар со скидкой?</h2><p>Приобрести товар со скидкой вы можете следующим способом:</p><ul><li><p>тематические распродажи – как правило, они посвящены определённому поводу и длятся указанный период: «чёрная пятница», «киберпонедельник», очередная годовщина интернет-магазина Алиэкспресс и прочее;</p></li><li><p>промокоды – специальное сочетание букв и цифр, предоставляющее скидку на покупку продукции;</p></li><li><p>мобильное приложение – сделав заказ в мобильном приложении, вы можете получить скидку на выбранный товар;</p></li><li><p>центр привилегий – программа лояльности, позволяющая пользователям получать подарки на годовщину или День Рождения, эксклюзивные цены на товары, а также баллы за отзывы и общение с продавцами;</p></li><li><p>подарочный сертификат - позволяет его владельцу оплатить покупку частично или полностью исходя из номинала карты и получать при необходимости более быстрый возврат;</p></li><li><p>монеты в приложении – их можно получить посредством игр и промоакций, а также обменять на товары или купоны.</p></li></ul><h2>Как применить купон в интернет-магазине Алиэкспресс?</h2><p>Самым распространённым инструментом получения скидки в онлайн шоппинге является промокод. Его можно получить за регистрацию или подписку за новостную рассылку, при первом заказе или без совершения дополнительных процедур в рамках определённой акции. Однако стоит отметить, что в корзине можно использоваться только одно значение купона, наиболее подходящее под выбранные товары. Также полученная скидка не суммируется с другими акциями. В интернет-магазине Алиэкспресс существует несколько видов промокодов:</p><ul><li><p>от AliExpress – распространяются на все товары, кроме продукции из раздела Молл;</p></li><li><p>от продавцов – используются для изделий того магазина, продавец которого предоставил данный купон;</p></li><li><p>спецкупоны – могут быть применены у определённых покупателей со специальной отметкой.</p></li></ul><p>Данный дисконт может быть выражен в процентном или денежном эквиваленте.</p><p>Для успешной активации промокода вам потребуется:</p><ol><li><p>скопировать значение промокода с данной страницы;</p></li><li><p>перейти на сайт интернет-магазина AliExpress и зарегистрироваться;</p></li><li><p>добавить в корзину товары;</p></li><li><p>выбрать в специальном поле предложенный купон;</p></li><li><p>нажать кнопку «Заказать у этого продавца»;</p></li><li><p>проверить активацию промокода;</p></li><li><p>завершить покупку.</p></li></ol><p>Стоит отметить, что на момент покупки срок действия купона должен быть актуальным. Также для его активации обычно требуется совершение покупки на определённую сумму. На некоторые категории товаров скидка по промокоду может не распространяться.</p><h2>Как оформить заказ в интернет-магазине Алиэкспресс?</h2><p>Ознакомившись с перечнем понравившейся продукции, остаётся оформить на неё заказ в несколько кликов:</p><ol><li><p>зарегистрируйтесь на сайте, авторизуйтесь через социальные сети или войдите в личный кабинет;</p></li><li><p>выберите вариант доставки;</p></li><li><p>добавьте понравившиеся товары в корзину;</p></li><li><p>укажите в отдельном поле выбранный купон и активируйте его;</p></li><li><p>заполните пустые поля контактных данных при необходимости;</p></li><li><p>укажите комментарий для продавца при желании;</p></li><li><p>выберите способ оплаты;</p></li><li><p>нажмите кнопку «Подтвердить и оплатить».</p></li></ol>',
                'contacts' => '<p>Тел: +7 (985) 289-50-00</p><p>Адрес: Москва, Комсомольская площадь, д. 5</p>',
                'payments' => '<ul><li>Банковская карта</li><li>Яндекс Деньги</li><li>Qiwi</li><li>Мобильный платеж</li><li>Наличный расчет</li><li>WebMoney</li><li>Безналичный перевод</li></ul><p><br></p>',
                'delivery' => '<ul><li>ePacket</li><li>AliExpress Standard Shipping&nbsp;</li><li>AliExpress Premium Shipping</li><li>EMS</li><li>Cainiao Standard For Special Goods</li><li>DHL</li></ul>',
            ],
        ],
        [
            'name' => 'Belka',
            'sort' => 2,
            'logoName' => 'belka.png',
        ],
        [
            'name' => 'Finn Flare',
            'sort' => 3,
            'logoName' => 'finn.jpg',
        ],
        [
            'name' => 'Sela',
            'sort' => 4,
            'logoName' => 'sela.jpg',
        ],
        [
            'name' => 'VANS',
            'sort' => 5,
            'logoName' => 'vans.jpg',
        ],
        [
            'name' => 'TOM TAILOR',
            'sort' => 6,
            'logoName' => 'tom.png',
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
        /** @var Category $clothesCategory */
        $clothesCategory = $this->getReference(CategoryFixture::REFERENCE_CLOTHES);

        foreach (self::CLOTHES_STORES as $data) {
            $store = $this->createStore(
                $clothesCategory,
                $author,
                $data['name'],
                $data['sort'],
                $data['logoName'],
                $data['seoHeading'] ?? null,
                $data['seoDescription'] ?? null,
                $data['metaTitle'] ?? null,
                $data['metaDescription'] ?? null,
                $data['metaOgTitle'] ?? null,
                $data['metaOgDescription'] ?? null,
                $data['description'] ?? null,
                $data['info'] ?? null,
            );
            $manager->persist($store);
            if ('Adidas' === $data['name']) {
                $this->setReference(self::REFERENCE_ADIDAS, $store);
            }
        }

        $manager->flush();
    }

    private function createStore(
        Category $category,
        Author $author,
        string $name,
        int $sort,
        string $logoName,
        ?string $seoHeading = null,
        ?string $seoDescription = null,
        ?string $metaTitle = null,
        ?string $metaDescription = null,
        ?string $metaOgTitle = null,
        ?string $metaOgDescription = null,
        ?string $description = null,
        ?array $info = null
    ): Store {
        $store = new Store(
            Id::next(),
            $author,
            $name,
            new DateTimeImmutable(),
            $this->slugger->slug($name)->lower()->toString(),
            new Seo(
                $seoHeading,
                $seoDescription
            ),
            new Meta(
                $metaTitle,
                $metaDescription,
                $metaOgTitle,
                $metaOgDescription
            ),
            new Info(
                null !== $info ? $info['detail'] : null,
                null !== $info ? $info['contacts'] : null,
                null !== $info ? $info['payments'] : null,
                null !== $info ? $info['delivery'] : null
            ),
            $sort,
            $description
        );
        $category->addStore($store);
        $store->addCategory($category);
        $store->setLogo(
            new Logo(
                LogoId::next(),
                $store,
                new LogoInfo(
                    'fixtures/stores',
                    $logoName,
                    1
                ),
                new DateTimeImmutable()
            )
        );

        return $store;
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixture::class,
            CategoryFixture::class,
        ];
    }
}
