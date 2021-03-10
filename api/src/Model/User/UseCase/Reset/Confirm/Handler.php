<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Reset\Confirm;

use App\Model\User\Entity\User\UserRepository;
use DomainException;

class Handler
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->users->findByResetToken($command->token)) {
            throw new DomainException('Неправильный или уже подтверждённый токен сброса пароля.');
        }
    }
}
