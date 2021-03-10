<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Reinstate;

use App\Model\Blog\Entity\Posts\Post\Id;
use App\Model\Blog\Entity\Posts\Post\PostRepository;
use App\Model\Flusher;

class Handler
{
    private PostRepository $posts;
    private Flusher $flusher;

    public function __construct(PostRepository $posts, Flusher $flusher)
    {
        $this->posts = $posts;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $post = $this->posts->get(new Id($command->id));

        $post->reinstate();

        $this->flusher->flush();
    }
}
