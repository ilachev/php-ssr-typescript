<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Promos\Promo\Edit;

use App\Model\Flusher;
use App\Model\Market\Entity\Promos\Promo\DiscountUnit;
use App\Model\Market\Entity\Promos\Promo\Id;
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
    private PromoRepository $promos;
    private Flusher $flusher;

    public function __construct(StoreRepository $stores, PromoRepository $promos, Flusher $flusher)
    {
        $this->stores = $stores;
        $this->promos = $promos;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $promo = $this->promos->get(new Id($command->id));
        $store = $this->stores->get(new StoreId($command->store));

        $promo->edit(
            $store,
            new Type($command->type),
            $command->name,
            new Seo($command->seoHeading),
            $command->startDate,
            $command->endDate,
            $command->description,
            $command->code,
            $command->discount,
            new DiscountUnit($command->discountUnit)
        );

        $referralLink = $promo->getReferralLink();

        if (null !== $referralLink) {
            $referralLink->edit($command->referralLink);
        } else {
            $promo->setReferralLink(
                new ReferralLink(
                    ReferralLinkId::next(),
                    $promo,
                    $command->referralLink,
                    new Ulid(),
                    new DateTimeImmutable(),
                ),
            );
        }

        $this->flusher->flush();
    }
}
