<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Categories\Category\Archive;

use App\Model\Blog\Entity\Categories\Category\CategoryRepository;
use App\Model\Blog\Entity\Categories\Category\Id;
use App\Model\Flusher;

class Handler
{
    private CategoryRepository $categories;
    private Flusher $flusher;

    public function __construct(CategoryRepository $categories, Flusher $flusher)
    {
        $this->categories = $categories;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $category = $this->categories->get(new Id($command->id));

        $category->archive();

        $this->flusher->flush();
    }
}
