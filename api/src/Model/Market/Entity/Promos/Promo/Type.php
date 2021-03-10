<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Promo;

use JetBrains\PhpStorm\Pure;
use Webmozart\Assert\Assert;

class Type
{
    public const COUPON = 'coupon';
    public const DISCOUNT = 'discount';
    public const PROMO_CODE = 'promo-code';

    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::COUPON,
            self::DISCOUNT,
            self::PROMO_CODE,
        ]);

        $this->name = $name;
    }

    #[Pure]
    public function isEqual(self $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return match ($this->name) {
            self::COUPON => 'Купоны',
            self::DISCOUNT => 'Скидки',
            self::PROMO_CODE => 'Промокоды',
            default => '',
        };
    }
}
