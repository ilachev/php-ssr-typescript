<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Author\Create;

use App\Model\Flusher;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Author\AuthorRepository;
use App\Model\Market\Entity\Author\Email;
use App\Model\Market\Entity\Author\Id;
use App\Model\Market\Entity\Author\Name;

class Handler
{
    private AuthorRepository $authors;
    private Flusher $flusher;

    public function __construct(AuthorRepository $authors, Flusher $flusher)
    {
        $this->authors = $authors;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->id);

        if ($this->authors->has($id)) {
            throw new \DomainException('Author already exists.');
        }

        $author = new Author(
            $id,
            new Name(
                $command->firstName,
                $command->lastName
            ),
            new Email($command->email)
        );

        $this->authors->add($author);

        $this->flusher->flush();
    }
}
