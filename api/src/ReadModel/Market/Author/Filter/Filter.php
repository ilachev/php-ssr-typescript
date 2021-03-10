<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Author\Filter;

use App\Model\Market\Entity\Author\Status;

class Filter
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $status = Status::ACTIVE;
}
