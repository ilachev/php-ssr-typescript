<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Reset\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $token = null;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
