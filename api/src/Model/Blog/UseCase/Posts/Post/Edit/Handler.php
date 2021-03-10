<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Edit;

use App\Model\Blog\Entity\Categories\Category\Category;
use App\Model\Blog\Entity\Categories\Category\CategoryRepository;
use App\Model\Blog\Entity\Categories\Category\Id as CategoryId;
use App\Model\Blog\Entity\Posts\Post\Id;
use App\Model\Blog\Entity\Posts\Post\Logo\Id as LogoId;
use App\Model\Blog\Entity\Posts\Post\Logo\Info as LogoInfo;
use App\Model\Blog\Entity\Posts\Post\Logo\Logo;
use App\Model\Blog\Entity\Posts\Post\Meta;
use App\Model\Blog\Entity\Posts\Post\PostRepository;
use App\Model\Blog\Entity\Posts\Post\Seo;
use App\Model\Flusher;
use DateTimeImmutable;

class Handler
{
    private PostRepository $posts;
    private CategoryRepository $categories;
    private Flusher $flusher;

    public function __construct(PostRepository $posts, CategoryRepository $categories, Flusher $flusher)
    {
        $this->posts = $posts;
        $this->categories = $categories;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $post = $this->posts->get(new Id($command->id));

        $post->edit(
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
            $command->description,
        );

        $logo = $command->logo;
        if ($logo) {
            if ($old = $post->getLogo()) {
                $post->removeLogo($old);

                $this->flusher->flush($post);
            }

            $post->setLogo(
                new Logo(
                    LogoId::next(),
                    $post,
                    new LogoInfo(
                        $logo->path,
                        $logo->name,
                        $logo->size
                    ),
                    new DateTimeImmutable()
                )
            );
        }

        /** @var Category $old */
        foreach ($post->getCategories() as $old) {
            $old->removePost($post);
            $post->removeCategory($old);
        }

        $categories = $command->categories;
        if ($categories) {
            foreach ($categories as $id) {
                $category = $this->categories->get(new CategoryId($id));
                $category->addPost($post);
                $post->addCategory($category);
            }
        }

        $this->flusher->flush($post);
    }
}
