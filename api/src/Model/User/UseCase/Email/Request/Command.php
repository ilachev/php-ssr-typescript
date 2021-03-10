<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Email\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $id = null;
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public ?string $email = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
