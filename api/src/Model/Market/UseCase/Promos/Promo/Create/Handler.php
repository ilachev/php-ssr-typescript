<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Promos\Promo\Create;

use App\Model\Flusher;
use App\Model\Market\Entity\Author\AuthorRepository;
use App\Model\Market\Entity\Author\Id as AuthorId;
use App\Model\Market\Entity\Promos\Promo\DiscountUnit;
use App\Model\Market\Entity\Promos\Promo\Promo;
use App\Model\Market\Entity\Promos\Promo\PromoRepository;
use App\Model\Market\Entity\Promos\Promo\ReferralLink\Id as ReferralLinkId;
use App\Model\Market\Entity\Promos\Promo\ReferralLink\ReferralLink;
use App\Model\Market\Entity\Promos\Promo\Seo;
use App\Model\Market\Entity\Promos\Promo\Type;
use App\Model\Market\Entity\Stores\Store\Id as StoreId;
use App\Model\Market\Entity\Stores\Store\StoreRepository;
use DateTimeImmutable;
use Symfony\Component\Uid\Ulid;

class Handler
{
    private StoreRepository $stores;
    private AuthorRepository $authors;
    private PromoRepository $promos;
    private Flusher $flusher;

    public function __construct(
        StoreRepository $stores,
        AuthorRepository $authors,
        PromoRepository $promos,
        Flusher $flusher
    ) {
        $this->stores = $stores;
        $this->authors = $authors;
        $this->promos = $promos;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $author = $this->authors->get(new AuthorId($command->author));
        $store = $this->stores->get(new StoreId($command->store));

        $promo = new Promo(
            $this->promos->nextId(),
            $author,
            $store,
            new Type($command->type),
            $command->name,
            new Seo($command->seoHeading),
            new DateTimeImmutable(),
            $command->startDate,
            $command->endDate,
            $command->description,
            $command->code,
            $command->discount,
            new DiscountUnit($command->discountUnit),
        );

        $promo->setReferralLink(
            new ReferralLink(
                ReferralLinkId::next(),
                $promo,
                $command->referralLink,
                new Ulid(),
                new DateTimeImmutable(),
            ),
        );

        $this->promos->add($promo);
        $this->flusher->flush();
    }
}
