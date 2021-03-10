<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Author\Edit;

use App\Model\Market\Entity\Author\Author;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public string $id;
    /**
     * @Assert\NotBlank()
     */
    public string $firstName;
    /**
     * @Assert\NotBlank()
     */
    public string $lastName;
    /**
     * @Assert\Email()
     */
    public string $email;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromAuthor(Author $author): self
    {
        $command = new self($author->getId()->getValue());
        $command->firstName = $author->getName()->getFirst();
        $command->lastName = $author->getName()->getLast();
        $command->email = $author->getEmail()->getValue();

        return $command;
    }
}
