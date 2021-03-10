<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Create;

class Logo
{
    public function __construct(
        public ?string $path = null,
        public ?string $name = null,
        public ?int $size = null,
    ) {
    }
}
