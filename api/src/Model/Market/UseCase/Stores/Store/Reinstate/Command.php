<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Reinstate;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
