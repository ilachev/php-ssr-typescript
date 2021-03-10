<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Edit;

use App\Model\Blog\Entity\Categories\Category\Category;
use App\Model\Blog\Entity\Posts\Post\Post;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $id = null;
    /**
     * @Assert\NotBlank()
     */
    public ?string $name = null;
    public ?array $categories = null;
    public ?string $description = null;
    /**
     * @Assert\NotBlank()
     */
    public string $slug;
    public ?int $sort = null;
    public ?string $metaTitle = null;
    public ?string $metaDescription = null;
    public ?string $metaOgTitle = null;
    public ?string $metaOgDescription = null;
    public ?string $seoHeading = null;
    public ?string $seoDescription = null;
    public ?Logo $logo = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromPost(Post $post): self
    {
        $command = new self($post->getId()->getValue());
        $command->name = $post->getName();
        $command->description = $post->getDescription();
        $command->categories = array_map(
            static fn (Category $category) => $category->getId()->getValue(),
            $post->getCategories()->toArray()
        );
        $command->slug = $post->getSlug();
        $command->sort = $post->getSort();
        $command->metaTitle = $post->getMeta()->getTitle();
        $command->metaDescription = $post->getMeta()->getDescription();
        $command->metaOgTitle = $post->getMeta()->getOgTitle();
        $command->metaOgDescription = $post->getMeta()->getOgDescription();
        $command->seoHeading = $post->getSeo()->getHeading();
        $command->seoDescription = $post->getSeo()->getHeading();

        return $command;
    }
}
