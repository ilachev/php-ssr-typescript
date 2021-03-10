<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Edit;

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
     * @Assert\Email()
     */
    public ?string $email = null;
    /**
     * @Assert\NotBlank()
     */
    public ?string $firstName = null;
    /**
     * @Assert\NotBlank()
     */
    public ?string $lastName = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromUser(User $user): self
    {
        $command = new self($user->getId()->getValue());
        $command->email = $user->getEmail()->getValue();
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();

        return $command;
    }
}
