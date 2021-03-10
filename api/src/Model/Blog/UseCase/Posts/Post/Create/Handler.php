<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Create;

use App\Model\Blog\Entity\Author\AuthorRepository;
use App\Model\Blog\Entity\Author\Id as AuthorId;
use App\Model\Blog\Entity\Categories\Category\CategoryRepository;
use App\Model\Blog\Entity\Categories\Category\Id as CategoryId;
use App\Model\Blog\Entity\Posts\Post\Id;
use App\Model\Blog\Entity\Posts\Post\Logo\Id as LogoId;
use App\Model\Blog\Entity\Posts\Post\Logo\Info as LogoInfo;
use App\Model\Blog\Entity\Posts\Post\Logo\Logo;
use App\Model\Blog\Entity\Posts\Post\Meta;
use App\Model\Blog\Entity\Posts\Post\Post;
use App\Model\Blog\Entity\Posts\Post\PostRepository;
use App\Model\Blog\Entity\Posts\Post\Seo;
use App\Model\Flusher;
use DateTimeImmutable;
use Symfony\Component\String\Slugger\SluggerInterface;

class Handler
{
    private SluggerInterface $slugger;
    private PostRepository $posts;
    private AuthorRepository $authors;
    private CategoryRepository $categories;
    private Flusher $flusher;

    public function __construct(
        SluggerInterface $slugger,
        PostRepository $posts,
        AuthorRepository $authors,
        CategoryRepository $categories,
        Flusher $flusher
    ) {
        $this->slugger = $slugger;
        $this->posts = $posts;
        $this->authors = $authors;
        $this->categories = $categories;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $author = $this->authors->get(new AuthorId($command->author));

        $post = new Post(
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
            $command->description,
        );

        $logo = $command->logo;
        if ($logo) {
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

        $categories = $command->categories;
        if ($categories) {
            foreach ($categories as $id) {
                $category = $this->categories->get(new CategoryId($id));
                $category->addPost($post);
                $post->addCategory($category);
            }
        }

        $this->posts->add($post);
        $this->flusher->flush();
    }
}
