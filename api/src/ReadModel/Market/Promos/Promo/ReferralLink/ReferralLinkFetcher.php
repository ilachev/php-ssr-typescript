<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Promos\Promo\ReferralLink;

use App\Model\Market\Entity\Promos\Promo\ReferralLink\ReferralLink;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\AbstractUid;

class ReferralLinkFetcher
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function findByInternalId(AbstractUid $id): ?ReferralLink
    {
        return $this->em->getRepository(ReferralLink::class)->findOneBy(['internalId' => $id]);
    }
}
