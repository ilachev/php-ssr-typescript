<?php

declare(strict_types=1);

namespace App\ReadModel\Search;

use JetBrains\PhpStorm\Pure;

class Filter
{
    public ?string $q = null;

    #[Pure]
    public static function all(): self
    {
        return new self();
    }
}
