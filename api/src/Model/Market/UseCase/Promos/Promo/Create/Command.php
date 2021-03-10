<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Promos\Promo\Create;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[Assert\NotBlank]
    public ?string $author = null;

    #[Assert\NotBlank]
    public ?string $name = null;

    #[Assert\NotBlank]
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

    #[Assert\NotNull]
    #[Assert\NotBlank]
    public ?string $discountUnit = null;

    #[Assert\Url]
    public string $referralLink;

    public function __construct(string $author)
    {
        $this->author = $author;
    }
}
