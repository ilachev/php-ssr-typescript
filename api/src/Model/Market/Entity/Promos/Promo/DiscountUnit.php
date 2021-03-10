<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Promo;

use Webmozart\Assert\Assert;

class DiscountUnit
{
    public const PERCENT = 'percent';
    public const RUBLE = 'ruble';
    public const DOLLAR = 'dollar';
    public const EURO = 'euro';

    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::PERCENT,
            self::RUBLE,
            self::DOLLAR,
            self::EURO,
        ]);

        $this->name = $name;
    }

    public function isEqual(self $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
