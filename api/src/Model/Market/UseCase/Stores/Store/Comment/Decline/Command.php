<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Comment\Decline;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[Assert\Uuid(versions: [Assert\Uuid::V4_RANDOM])]
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
