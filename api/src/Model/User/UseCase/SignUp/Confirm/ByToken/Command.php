<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SignUp\Confirm\ByToken;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank(message="Неверный токен.")
     */
    public string $token = '';

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
