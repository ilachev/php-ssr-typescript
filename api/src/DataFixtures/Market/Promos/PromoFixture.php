<?php

declare(strict_types=1);

namespace App\DataFixtures\Market\Promos;

use App\DataFixtures\Market\Author\AuthorFixture;
use App\DataFixtures\Market\Stores\StoreFixture;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Promos\Promo\Promo;
use App\Model\Market\Entity\Promos\Promo\PromoRepository;
use App\Model\Market\Entity\Promos\Promo\ReferralLink\Id as ReferralLinkId;
use App\Model\Market\Entity\Promos\Promo\ReferralLink\ReferralLink;
use App\Model\Market\Entity\Promos\Promo\Seo;
use App\Model\Market\Entity\Promos\Promo\Type;
use App\Model\Market\Entity\Stores\Store\Store;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Ulid;

class PromoFixture extends Fixture implements DependentFixtureInterface
{
    private PromoRepository $promos;

    public function __construct(PromoRepository $promos)
    {
        $this->promos = $promos;
    }

    public function load(ObjectManager $manager): void
    {
        /** @var Author $author */
        $author = $this->getReference(AuthorFixture::REFERENCE_ADMIN);
        /** @var Store $store */
        $store = $this->getReference(StoreFixture::REFERENCE_ADIDAS);

        foreach ($this->getPromosData() as $data) {
            $promo = $this->createPromo(
                $author,
                $store,
                $data['type'],
                $data['name'],
                $data['h1'],
                new DateTimeImmutable($data['begin_date']),
                new DateTimeImmutable($data['end_date']),
                $data['referral'],
                $data['description'],
                $data['code'],
                $data['discount'],
            );

            $manager->persist($promo);
        }
        $manager->flush();
    }

    private function createPromo(
        Author $author,
        Store $store,
        string $type,
        string $name,
        string $h1,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        string $referral,
        ?string $description = null,
        ?string $code = null,
        ?int $discount = null,
    ): Promo {
        $promo = new Promo(
            $this->promos->nextId(),
            $author,
            $store,
            new Type($type),
            $name,
            new Seo($h1),
            new DateTimeImmutable(),
            $startDate,
            $endDate,
            $description,
            $code,
            $discount
        );

        $promo->setReferralLink(
            new ReferralLink(
                ReferralLinkId::next(),
                $promo,
                $referral,
                new Ulid(),
                new DateTimeImmutable(),
            )
        );

        return $promo;
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixture::class,
            StoreFixture::class,
        ];
    }

    private function getPromosData(): array
    {
        return [
            [
                'name' => 'До 50% на товары для интерьера',
                'type' => Type::DISCOUNT,
                'code' => null,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => '30.06.2020 00:00',
                'discount' => 50,
                'description' => 'В данной категории представлены скидки до 50% на электротехнику для дома. Электропылесосы, мойщики окон, увлажнители и другие товары со скидкой',
                'h1' => 'До 50% на товары для интерьера',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Купон на 125 рублей',
                'type' => Type::COUPON,
                'code' => null,
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => '30.06.2020 00:00',
                'description' => 'С 15 июн., 10:00 (МСК) — 1 июл., 00:00 (МСК) доступен новый купон на 125 рублей при покупке от 100. Переходите по ссылке и добавляйте себе.',
                'h1' => 'До 50% на товары для интерьера',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод Aliexpress $3 на все',
                'type' => Type::PROMO_CODE,
                'code' => 'HD030',
                'discount' => 3,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => '30.06.2020 00:00',
                'description' => 'Код на $3 (250 рублей) для новых пользователей при заказе от $4 (330 руб.)',
                'h1' => 'Промокод Aliexpress $3 для новых пользователей',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод на 250 рублей для доставки из РФ',
                'type' => Type::PROMO_CODE,
                'code' => 'JUNE250',
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => '30.06.2020 00:00',
                'description' => 'Промокод на скидка 250 руб. при покупке от 2000 при доставке из РФ (tmall)',
                'h1' => 'Промокод на 250 рублей для доставки из РФ',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Топ-скидки за неделю',
                'type' => Type::DISCOUNT,
                'code' => null,
                'discount' => 90,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => '24.06.2020 00:00',
                'description' => 'Еженедельно Алиэкспресс предлагает скидки до 90% на популярные товары. Переходите по ссылке и выбирайте понравившийся товар по низкой цене.',
                'h1' => 'Топ-скидки за неделю на Алиэкспресс',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Центр купонов',
                'type' => Type::COUPON,
                'code' => null,
                'discount' => null,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => '24.06.2020 00:00',
                'description' => 'На одной странице представлены все активные купоны от лучших продавцов на Алиэкспресс.',
                'h1' => 'Центр купонов Aliexpress',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'До 50% на товары для интерьера',
                'type' => Type::DISCOUNT,
                'code' => null,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'discount' => 50,
                'description' => 'В данной категории представлены скидки до 50% на электротехнику для дома. Электропылесосы, мойщики окон, увлажнители и другие товары со скидкой',
                'h1' => 'До 50% на товары для интерьера',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Купон на 125 рублей',
                'type' => Type::COUPON,
                'code' => null,
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'С 15 июн., 10:00 (МСК) — 1 июл., 00:00 (МСК) доступен новый купон на 125 рублей при покупке от 100. Переходите по ссылке и добавляйте себе.',
                'h1' => 'До 50% на товары для интерьера',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод Aliexpress $3 на все',
                'type' => Type::PROMO_CODE,
                'code' => 'HD030',
                'discount' => 3,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'Код на $3 (250 рублей) для новых пользователей при заказе от $4 (330 руб.)',
                'h1' => 'Промокод Aliexpress $3 для новых пользователей',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод на 250 рублей для доставки из РФ',
                'type' => Type::PROMO_CODE,
                'code' => 'JUNE250',
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P4M'))->format(DATE_ATOM),
                'description' => 'Промокод на скидка 250 руб. при покупке от 2000 при доставке из РФ (tmall)',
                'h1' => 'Промокод на 250 рублей для доставки из РФ',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод Aliexpress $3 на все',
                'type' => Type::PROMO_CODE,
                'code' => 'HD030',
                'discount' => 3,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'Код на $3 (250 рублей) для новых пользователей при заказе от $4 (330 руб.)',
                'h1' => 'Промокод Aliexpress $3 для новых пользователей',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод на 250 рублей для доставки из РФ',
                'type' => Type::PROMO_CODE,
                'code' => 'JUNE250',
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P4M'))->format(DATE_ATOM),
                'description' => 'Промокод на скидка 250 руб. при покупке от 2000 при доставке из РФ (tmall)',
                'h1' => 'Промокод на 250 рублей для доставки из РФ',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод Aliexpress $3 на все',
                'type' => Type::PROMO_CODE,
                'code' => 'HD030',
                'discount' => 3,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'Код на $3 (250 рублей) для новых пользователей при заказе от $4 (330 руб.)',
                'h1' => 'Промокод Aliexpress $3 для новых пользователей',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод на 250 рублей для доставки из РФ',
                'type' => Type::PROMO_CODE,
                'code' => 'JUNE250',
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P4M'))->format(DATE_ATOM),
                'description' => 'Промокод на скидка 250 руб. при покупке от 2000 при доставке из РФ (tmall)',
                'h1' => 'Промокод на 250 рублей для доставки из РФ',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Топ-скидки за неделю',
                'type' => Type::DISCOUNT,
                'code' => null,
                'discount' => 90,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'Еженедельно Алиэкспресс предлагает скидки до 90% на популярные товары. Переходите по ссылке и выбирайте понравившийся товар по низкой цене.',
                'h1' => 'Топ-скидки за неделю на Алиэкспресс',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Центр купонов',
                'type' => Type::COUPON,
                'code' => null,
                'discount' => null,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P3M'))->format(DATE_ATOM),
                'description' => 'На одной странице представлены все активные купоны от лучших продавцов на Алиэкспресс.',
                'h1' => 'Центр купонов Aliexpress',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'До 50% на товары для интерьера',
                'type' => Type::DISCOUNT,
                'code' => null,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'discount' => 50,
                'description' => 'В данной категории представлены скидки до 50% на электротехнику для дома. Электропылесосы, мойщики окон, увлажнители и другие товары со скидкой',
                'h1' => 'До 50% на товары для интерьера',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Купон на 125 рублей',
                'type' => Type::COUPON,
                'code' => null,
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'С 15 июн., 10:00 (МСК) — 1 июл., 00:00 (МСК) доступен новый купон на 125 рублей при покупке от 100. Переходите по ссылке и добавляйте себе.',
                'h1' => 'До 50% на товары для интерьера',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод Aliexpress $3 на все',
                'type' => Type::PROMO_CODE,
                'code' => 'HD030',
                'discount' => 3,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'Код на $3 (250 рублей) для новых пользователей при заказе от $4 (330 руб.)',
                'h1' => 'Промокод Aliexpress $3 для новых пользователей',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод на 250 рублей для доставки из РФ',
                'type' => Type::PROMO_CODE,
                'code' => 'JUNE250',
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P4M'))->format(DATE_ATOM),
                'description' => 'Промокод на скидка 250 руб. при покупке от 2000 при доставке из РФ (tmall)',
                'h1' => 'Промокод на 250 рублей для доставки из РФ',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод Aliexpress $3 на все',
                'type' => Type::PROMO_CODE,
                'code' => 'HD030',
                'discount' => 3,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'Код на $3 (250 рублей) для новых пользователей при заказе от $4 (330 руб.)',
                'h1' => 'Промокод Aliexpress $3 для новых пользователей',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод на 250 рублей для доставки из РФ',
                'type' => Type::PROMO_CODE,
                'code' => 'JUNE250',
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P4M'))->format(DATE_ATOM),
                'description' => 'Промокод на скидка 250 руб. при покупке от 2000 при доставке из РФ (tmall)',
                'h1' => 'Промокод на 250 рублей для доставки из РФ',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод Aliexpress $3 на все',
                'type' => Type::PROMO_CODE,
                'code' => 'HD030',
                'discount' => 3,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'Код на $3 (250 рублей) для новых пользователей при заказе от $4 (330 руб.)',
                'h1' => 'Промокод Aliexpress $3 для новых пользователей',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Промокод на 250 рублей для доставки из РФ',
                'type' => Type::PROMO_CODE,
                'code' => 'JUNE250',
                'discount' => 50,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P4M'))->format(DATE_ATOM),
                'description' => 'Промокод на скидка 250 руб. при покупке от 2000 при доставке из РФ (tmall)',
                'h1' => 'Промокод на 250 рублей для доставки из РФ',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Топ-скидки за неделю',
                'type' => Type::DISCOUNT,
                'code' => null,
                'discount' => 90,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P2M'))->format(DATE_ATOM),
                'description' => 'Еженедельно Алиэкспресс предлагает скидки до 90% на популярные товары. Переходите по ссылке и выбирайте понравившийся товар по низкой цене.',
                'h1' => 'Топ-скидки за неделю на Алиэкспресс',
                'referral' => 'http://adidas.ru',
            ],
            [
                'name' => 'Центр купонов',
                'type' => Type::COUPON,
                'code' => null,
                'discount' => null,
                'begin_date' => '17.06.2020 00:00',
                'end_date' => (new DateTimeImmutable())->add(new DateInterval('P3M'))->format(DATE_ATOM),
                'description' => 'На одной странице представлены все активные купоны от лучших продавцов на Алиэкспресс.',
                'h1' => 'Центр купонов Aliexpress',
                'referral' => 'http://adidas.ru',
            ],
        ];
    }
}
