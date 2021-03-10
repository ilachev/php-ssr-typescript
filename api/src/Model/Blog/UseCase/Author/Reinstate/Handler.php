<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Author\Reinstate;

use App\Model\Blog\Entity\Author\AuthorRepository;
use App\Model\Blog\Entity\Author\Id;
use App\Model\Flusher;

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

        $author->reinstate();

        $this->flusher->flush();
    }
}
