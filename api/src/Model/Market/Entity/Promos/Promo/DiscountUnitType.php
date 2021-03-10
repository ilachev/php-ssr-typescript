<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Promo;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class DiscountUnitType extends StringType
{
    public const NAME = 'market_promos_promo_discount_unit';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof DiscountUnit ? $value->getName() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new DiscountUnit($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
