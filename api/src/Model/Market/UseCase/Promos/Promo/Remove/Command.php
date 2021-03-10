<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Promos\Promo\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
