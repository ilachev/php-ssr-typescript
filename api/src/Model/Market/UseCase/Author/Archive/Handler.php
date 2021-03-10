<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Author\Archive;

use App\Model\Flusher;
use App\Model\Market\Entity\Author\AuthorRepository;
use App\Model\Market\Entity\Author\Id;

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

        $author->archive();

        $this->flusher->flush();
    }
}
