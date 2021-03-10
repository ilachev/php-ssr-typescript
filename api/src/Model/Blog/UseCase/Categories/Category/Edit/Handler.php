<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Categories\Category\Edit;

use App\Model\Blog\Entity\Categories\Category\CategoryRepository;
use App\Model\Blog\Entity\Categories\Category\Id;
use App\Model\Blog\Entity\Categories\Category\Meta;
use App\Model\Blog\Entity\Categories\Category\Seo;
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
        $parent = null !== $command->parent ? $this->categories->get(new Id($command->parent)) : null;

        $category->edit(
            $command->name,
            $command->slug,
            new Seo(
                $command->seoHeading,
                $command->seoTitle,
                $command->seoDescription,
            ),
            new Meta(
                $command->metaTitle,
                $command->metaDescription,
                $command->metaOgTitle,
                $command->metaOgDescription
            ),
            $command->sort,
            $parent,
            $command->description,
        );

        $this->flusher->flush();
    }
}
