<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Stores\Store\Event;

use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Stores\Store\Comment\Id;

class StoreCommentCreated
{
    public function __construct(
        public Id $id,
        public Author $author,
        public string $text,
    ) {
    }
}
