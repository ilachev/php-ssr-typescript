<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Posts\Post\Event;

use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Posts\Post\Comment\Id;

class PostCommentCreated
{
    public function __construct(
        public Id $id,
        public Author $author,
        public string $text,
    ) {
    }
}
