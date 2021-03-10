<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Comment\Approve;

use App\Model\Blog\Entity\Posts\Post\Comment\CommentRepository;
use App\Model\Blog\Entity\Posts\Post\Comment\Id;
use App\Model\Flusher;

class Handler
{
    public function __construct(
        private CommentRepository $comments,
        private Flusher $flusher,
    ) {
    }

    public function handle(Command $command): void
    {
        $comment = $this->comments->get(new Id($command->id));

        $comment->approve();

        $this->flusher->flush();
    }
}
