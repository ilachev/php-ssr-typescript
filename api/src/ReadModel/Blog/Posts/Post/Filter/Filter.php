<?php

declare(strict_types=1);

namespace App\ReadModel\Blog\Posts\Post\Filter;

use App\Model\Blog\Entity\Posts\Post\Status;
use JetBrains\PhpStorm\Pure;

class Filter
{
    public ?string $category = null;
    public ?string $name = null;
    public ?string $status = Status::ACTIVE;

    #[Pure]
    public static function all(): self
    {
        return new self();
    }
}
