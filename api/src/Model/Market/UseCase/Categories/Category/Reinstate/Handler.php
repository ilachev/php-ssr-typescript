<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Categories\Category\Reinstate;

use App\Model\Flusher;
use App\Model\Market\Entity\Categories\Category\CategoryRepository;
use App\Model\Market\Entity\Categories\Category\Id;

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

        $category->reinstate();

        $this->flusher->flush();
    }
}
