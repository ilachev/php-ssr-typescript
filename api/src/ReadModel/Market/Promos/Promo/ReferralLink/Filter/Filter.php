<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Promos\Promo\ReferralLink\Filter;

use JetBrains\PhpStorm\Pure;

class Filter
{
    public string $ulid = '';

    #[Pure]
    public static function all(): self
    {
        return new self();
    }
}
