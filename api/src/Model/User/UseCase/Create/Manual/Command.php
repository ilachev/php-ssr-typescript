<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Create\Manual;

class Command
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
