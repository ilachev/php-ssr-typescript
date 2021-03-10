<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Stores\Store\Filter;

use App\Model\Market\Entity\Stores\Store\Status;

class Filter
{
    public ?string $name = null;
    public ?string $category = null;
    public ?string $status = Status::ACTIVE;

    public static function all(): self
    {
        return new self();
    }
}
