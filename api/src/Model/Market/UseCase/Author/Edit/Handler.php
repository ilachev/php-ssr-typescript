<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Author\Edit;

use App\Model\Flusher;
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
        $author = $this->authors->get(new Id($command->id));

        $author->edit(
            new Name(
                $command->firstName,
                $command->lastName
            ),
            new Email($command->email)
        );

        $this->flusher->flush();
    }
}
