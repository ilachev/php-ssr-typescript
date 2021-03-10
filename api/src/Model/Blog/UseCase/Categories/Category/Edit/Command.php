<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Categories\Category\Edit;

use App\Model\Blog\Entity\Categories\Category\Category;
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
    public ?string $seoTitle = null;
    public ?string $seoDescription = null;
    /**
     * @Assert\Expression(
     *     "this.getId() != this.getParent()"
     * )
     */
    public ?string $parent = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromCategory(Category $category): self
    {
        $command = new self($category->getId()->getValue());
        $command->name = $category->getName();
        $command->description = $category->getDescription();
        $command->slug = $category->getSlug();
        $command->parent = $category->getParent() ? $category->getParent()->getId()->getValue() : null;
        $command->sort = $category->getSort();
        $command->metaTitle = $category->getMeta()->getTitle();
        $command->metaDescription = $category->getMeta()->getDescription();
        $command->metaOgTitle = $category->getMeta()->getOgTitle();
        $command->metaOgDescription = $category->getMeta()->getOgDescription();
        $command->seoHeading = $category->getSeo()->getHeading();
        $command->seoTitle = $category->getSeo()->getTitle();
        $command->seoDescription = $category->getSeo()->getHeading();

        return $command;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }
}
