<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Promo\ReferralLink;

use App\Model\Market\Entity\Promos\Promo\Promo;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

/**
 * @ORM\Entity()
 * @ORM\Table(name="market_promos_promo_referral_links", indexes={
 *     @ORM\Index(columns={"date", "internal_id"})
 * })
 */
class ReferralLink
{
    /**
     * @ORM\Column(type="market_promos_promo_referral_link_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Model\Market\Entity\Promos\Promo\Promo", inversedBy="referralLink")
     * @ORM\JoinColumn(name="promo_id", referencedColumnName="id", nullable=false)
     */
    private Promo $promo;
    /**
     * @ORM\Column(type="text")
     */
    private string $link;
    /**
     * @ORM\Column(type="ulid")
     */
    private Ulid $internalId;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;
    /**
     * @ORM\Version()
     * @ORM\Column(type="integer")
     */
    private int $version;

    public function __construct(
        Id $id,
        Promo $promo,
        string $link,
        Ulid $internalId,
        DateTimeImmutable $date,
    ) {
        $this->id = $id;
        $this->promo = $promo;
        $this->link = $link;
        $this->internalId = $internalId;
        $this->date = $date;
    }

    public function edit(
        string $link,
    ) {
        $this->link = $link;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getPromo(): Promo
    {
        return $this->promo;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getInternalId(): Ulid
    {
        return $this->internalId;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
