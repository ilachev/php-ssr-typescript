<?php

declare(strict_types=1);

namespace App\ReadModel\Blog\Categories\Category\Filter;

use App\Model\Blog\Entity\Categories\Category\Status;

class Filter
{
    public ?string $name = null;
    public ?string $status = Status::ACTIVE;

    public static function all(): self
    {
        return new self();
    }
}
