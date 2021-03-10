<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Name;

use App\Model\User\Entity\User\User;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $id = null;
    /**
     * @Assert\NotBlank()
     */
    public ?string $first = null;
    /**
     * @Assert\NotBlank()
     */
    public ?string $last = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromUser(User $user): self
    {
        $command = new self($user->getId()->getValue());
        $command->first = $user->getName()->getFirst();
        $command->last = $user->getName()->getLast();

        return $command;
    }
}
