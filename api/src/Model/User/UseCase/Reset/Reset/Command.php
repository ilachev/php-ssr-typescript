<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Reset\Reset;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $token = null;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=6)
     */
    public ?string $password = null;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
