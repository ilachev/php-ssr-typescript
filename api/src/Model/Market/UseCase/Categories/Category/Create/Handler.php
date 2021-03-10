<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Categories\Category\Create;

use App\Model\Flusher;
use App\Model\Market\Entity\Author\AuthorRepository;
use App\Model\Market\Entity\Author\Id as AuthorId;
use App\Model\Market\Entity\Categories\Category\Category;
use App\Model\Market\Entity\Categories\Category\CategoryRepository;
use App\Model\Market\Entity\Categories\Category\Id;
use App\Model\Market\Entity\Categories\Category\Logo\Id as LogoId;
use App\Model\Market\Entity\Categories\Category\Logo\Info;
use App\Model\Market\Entity\Categories\Category\Logo\Logo;
use App\Model\Market\Entity\Categories\Category\Meta;
use App\Model\Market\Entity\Categories\Category\Seo;
use DateTimeImmutable;
use Symfony\Component\String\Slugger\SluggerInterface;

class Handler
{
    private SluggerInterface $slugger;
    private CategoryRepository $categories;
    private AuthorRepository $authors;
    private Flusher $flusher;

    public function __construct(
        SluggerInterface $slugger,
        CategoryRepository $categories,
        AuthorRepository $authors,
        Flusher $flusher
    ) {
        $this->slugger = $slugger;
        $this->categories = $categories;
        $this->authors = $authors;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $author = $this->authors->get(new AuthorId($command->author));
        $parent = null !== $command->parent ? $this->categories->get(new Id($command->parent)) : null;

        $category = new Category(
            Id::next(),
            $author,
            $command->name,
            new DateTimeImmutable(),
            $this->slugger->slug($command->name)->lower()->toString(),
            new Seo(
                $command->seoHeading,
                $command->seoDescription
            ),
            new Meta(
                $command->metaTitle,
                $command->metaDescription,
                $command->metaOgTitle,
                $command->metaOgDescription
            ),
            $command->sort,
            $parent,
            $command->description
        );

        $logo = $command->logo;
        if ($logo) {
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

        $this->categories->add($category);
        $this->flusher->flush();
    }
}
