<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Categories\Category\Edit;

use App\Model\Flusher;
use App\Model\Market\Entity\Categories\Category\CategoryRepository;
use App\Model\Market\Entity\Categories\Category\Id;
use App\Model\Market\Entity\Categories\Category\Logo\Id as LogoId;
use App\Model\Market\Entity\Categories\Category\Logo\Info;
use App\Model\Market\Entity\Categories\Category\Logo\Logo;
use App\Model\Market\Entity\Categories\Category\Meta;
use App\Model\Market\Entity\Categories\Category\Seo;
use DateTimeImmutable;

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
        $logo = $command->logo;
        if ($logo) {
            if ($old = $category->getLogo()) {
                $category->removeLogo($old);

                $this->flusher->flush($category);
            }

            $category->setLogo(
                new Logo(
                    LogoId::next(),
                    $category,
                    new Info(
                        $logo->path,
                        $logo->name,
                        $logo->size
                    ),
                    new DateTimeImmutable()
                )
            );
        }

        $this->flusher->flush();
    }
}
