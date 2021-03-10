<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Promos\Promo\Edit;

use App\Model\Market\Entity\Promos\Promo\Promo;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[Assert\NotBlank]
    public ?int $id = null;

    #[Assert\NotBlank]
    public ?string $name = null;

    public ?string $type = null;

    public ?string $description = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    public ?int $discount = null;

    public ?string $code = null;

    #[Assert\NotNull]
    public ?DateTimeImmutable $startDate = null;

    #[Assert\NotNull]
    public ?DateTimeImmutable $endDate = null;

    #[Assert\NotBlank]
    public ?string $store = null;

    public ?string $seoHeading = null;

    #[Assert\Url]
    public ?string $referralLink = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    public ?string $discountUnit = null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromPromo(Promo $promo): self
    {
        $command = new self($promo->getId()->getValue());
        $command->name = $promo->getName();
        $command->type = $promo->getType()->getName();
        $command->description = $promo->getDescription();
        $command->discount = $promo->getDiscount();
        $command->code = $promo->getCode();
        $command->startDate = $promo->getStartDate();
        $command->endDate = $promo->getEndDate();
        $command->store = $promo->getStore()->getId()->getValue();
        $command->seoHeading = $promo->getSeo()->getHeading();
        $command->referralLink = $promo->getReferralLink()?->getLink();
        $command->discountUnit = null !== $promo->getDiscountUnit() ? $promo->getDiscountUnit()->getName() : null;

        return $command;
    }
}
