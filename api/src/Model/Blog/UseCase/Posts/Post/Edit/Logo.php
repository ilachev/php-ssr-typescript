<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Edit;

class Logo
{
    public ?string $path = null;
    public ?string $name = null;
    public ?int $size = null;

    public function __construct(string $path, string $name, int $size)
    {
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
    }
}
