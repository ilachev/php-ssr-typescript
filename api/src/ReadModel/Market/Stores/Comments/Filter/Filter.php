<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Stores\Comments\Filter;

use JetBrains\PhpStorm\Pure;

class Filter
{
    public ?string $slug = null;
    public ?string $status = null;

    #[Pure]
    public static function all(): self
    {
        return new self();
    }
}
