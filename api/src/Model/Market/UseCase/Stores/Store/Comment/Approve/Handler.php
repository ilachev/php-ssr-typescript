<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Comment\Approve;

use App\Model\Flusher;
use App\Model\Market\Entity\Stores\Store\Comment\CommentRepository;
use App\Model\Market\Entity\Stores\Store\Comment\Id;

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
