<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Promos\Promo\Filter;

use JetBrains\PhpStorm\Pure;

class Filter
{
    public ?string $name = null;
    public ?string $type = null;
    public ?string $store = null;
    public ?string $status = null;
    public ?string $slug = null;
    public ?string $isExpired = null;

    #[Pure]
    public static function all(): self
    {
        return new self();
    }
}
