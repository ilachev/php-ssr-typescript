<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User\Event;

use App\Model\User\Entity\User\Id;

class UserConfirmed
{
    public function __construct(
        public Id $id,
        public string $fullName,
        public string $firstName,
        public string $lastName,
        public string $email,
    ) {
    }
}
