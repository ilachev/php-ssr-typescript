<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Promo;

use App\Model\AggregateRoot;
use App\Model\EventsTrait;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Promos\Promo\ReferralLink\ReferralLink;
use App\Model\Market\Entity\Stores\Store\Store;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity
 * @ORM\Table(name="market_promos_promos", indexes={
 *     @ORM\Index(columns={"date", "start_date", "end_date"})
 * })
 */
class Promo implements AggregateRoot
{
    use EventsTrait;

    /**
     * @ORM\Column(type="market_promos_promo_id")
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\SequenceGenerator(sequenceName="market_promos_promo_seq", initialValue=1)
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Market\Entity\Stores\Store\Store")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", nullable=false)
     */
    private Store $store;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Market\Entity\Author\Author")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Author $author;
    /**
     * @ORM\Column(type="string")
     */
    private string $name;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $discount = null;
    /**
     * @ORM\Column(type="market_promos_promo_discount_unit", length=16, nullable=true)
     */
    private ?DiscountUnit $discountUnit = null;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $code = null;
    /**
     * @ORM\Column(type="market_promos_promo_type", length=16)
     */
    private Type $type;
    /**
     * @ORM\Embedded(class="Seo")
     */
    private Seo $seo;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private DateTimeImmutable $updateDate;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $startDate = null;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $endDate = null;
    /**
     * @ORM\Column(type="market_promos_promo_status", length=16, options={"default" : Status::ACTIVE})
     */
    private Status $status;
    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Model\Market\Entity\Promos\Promo\ReferralLink\ReferralLink",
     *     mappedBy="promo",
     *     orphanRemoval=true,
     *     cascade={"all"}
     * )
     */
    private ?ReferralLink $referralLink = null;
    /**
     * @ORM\Version()
     * @ORM\Column(type="integer")
     */
    private int $version;

    public function __construct(
        Id $id,
        Author $author,
        Store $store,
        Type $type,
        string $name,
        Seo $seo,
        DateTimeImmutable $date,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        ?string $description = null,
        ?string $code = null,
        ?int $discount = null,
        ?DiscountUnit $discountUnit = null,
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->store = $store;
        $this->type = $type;
        $this->name = $name;
        $this->seo = $seo;
        $this->date = $date;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->description = $description;
        $this->code = $code;
        $this->discount = $discount;
        $this->status = new Status(Status::ACTIVE);
        $this->discountUnit = $discountUnit;
    }

    public function edit(
        Store $store,
        Type $type,
        string $name,
        Seo $seo,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        ?string $description = null,
        ?string $code = null,
        ?int $discount = null,
        ?DiscountUnit $discountUnit = null,
    ): void {
        $this->store = $store;
        $this->type = $type;
        $this->name = $name;
        $this->seo = $seo;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->description = $description;
        $this->code = $code;
        $this->discount = $discount;
        $this->discountUnit = $discountUnit;
        $this->updateDate = new DateTimeImmutable();
    }

    public function archive(): void
    {
        if ($this->status->isArchived()) {
            throw new \DomainException('Промо уже в архиве.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->status->isActive()) {
            throw new \DomainException('Промо уже активно.');
        }
        $this->status = Status::active();
    }

    #[Pure]
    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    #[Pure]
    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getStore(): Store
    {
        return $this->store;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function getDiscountUnit(): ?DiscountUnit
    {
        return $this->discountUnit;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getSeo(): Seo
    {
        return $this->seo;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getStartDate(): ?DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getReferralLink(): ?ReferralLink
    {
        return $this->referralLink;
    }

    public function setReferralLink(ReferralLink $referralLink): void
    {
        $this->referralLink = $referralLink;
    }

    public function removeReferralLink(): void
    {
        $this->referralLink = null;
    }
}
