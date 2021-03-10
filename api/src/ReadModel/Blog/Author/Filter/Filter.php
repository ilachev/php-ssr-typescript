<?php

declare(strict_types=1);

namespace App\ReadModel\Blog\Author\Filter;

use App\Model\Blog\Entity\Author\Status;

class Filter
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $status = Status::ACTIVE;
}
