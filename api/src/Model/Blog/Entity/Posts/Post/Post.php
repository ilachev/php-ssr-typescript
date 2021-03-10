<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Posts\Post;

use App\Model\AggregateRoot;
use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Categories\Category\Category;
use App\Model\Blog\Entity\Posts\Post\Comment\Comment;
use App\Model\Blog\Entity\Posts\Post\Event\PostLogoRemoved;
use App\Model\Blog\Entity\Posts\Post\Logo\Logo;
use App\Model\EventsTrait;
use App\Model\SeoProcessable;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_posts_posts", indexes={
 *     @ORM\Index(columns={"date", "sort"})
 * })
 */
class Post implements AggregateRoot, SeoProcessable
{
    use EventsTrait;

    /**
     * @ORM\Column(type="blog_posts_post_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @var Collection<Category>
     * @ORM\ManyToMany(targetEntity="App\Model\Blog\Entity\Categories\Category\Category", mappedBy="posts")
     * @ORM\JoinTable(name="blog_posts_categories",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private Collection $categories;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Blog\Entity\Author\Author")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Author $author;
    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Model\Blog\Entity\Posts\Post\Logo\Logo",
     *     mappedBy="post",
     *     orphanRemoval=true,
     *     cascade={"all"}
     * )
     */
    private ?Logo $logo = null;
    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Blog\Entity\Posts\Post\Comment\Comment",
     *     mappedBy="post"
     * )
     */
    private Collection $comments;
    /**
     * @ORM\Column(type="string")
     */
    private string $name;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $slug;
    /**
     * @ORM\Embedded(class="Seo")
     */
    private Seo $seo;
    /**
     * @ORM\Embedded(class="Meta")
     */
    private Meta $meta;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private DateTimeImmutable $updateDate;
    /**
     * @ORM\Column(type="blog_posts_post_status", length=16, options={"default" : Status::ACTIVE})
     */
    private Status $status;
    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private int $sort;
    /**
     * @ORM\Version()
     * @ORM\Column(type="integer")
     */
    private int $version;

    public function __construct(
        Id $id,
        Author $author,
        string $name,
        DateTimeImmutable $date,
        string $slug,
        Seo $seo,
        Meta $meta,
        int $sort,
        ?string $description = null
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->name = $name;
        $this->date = $date;
        $this->slug = $slug;
        $this->seo = $seo;
        $this->meta = $meta;
        $this->sort = $sort;
        $this->description = $description;
        $this->status = new Status(Status::ACTIVE);
        $this->categories = new ArrayCollection();
    }

    public function edit(
        string $name,
        string $slug,
        Seo $seo,
        Meta $meta,
        int $sort,
        ?string $description = null
    ): void {
        $this->name = $name;
        $this->slug = $slug;
        $this->seo = $seo;
        $this->meta = $meta;
        $this->sort = $sort;
        $this->description = $description;
        $this->updateDate = new DateTimeImmutable();
    }

    public function archive(): void
    {
        if ($this->status->isArchived()) {
            throw new \DomainException('Магазин уже в архиве.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->status->isActive()) {
            throw new \DomainException('Магазин уже активен.');
        }
        $this->status = Status::active();
    }

    #[Pure]
    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    #[Pure]
    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function addCategory(Category $category): void
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }
    }

    public function removeCategory(Category $category): void
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }
    }

    public function addComment(Comment $comment): void
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }
    }

    public function removeComment(Comment $comment): void
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
        }
    }

    public function setLogo(Logo $logo): void
    {
        $this->logo = $logo;
    }

    public function removeLogo(Logo $logo): void
    {
        $this->logo = null;
        $this->recordEvent(new PostLogoRemoved($logo->getInfo()));
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getSeo(): Seo
    {
        return $this->seo;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function getLogo(): ?Logo
    {
        return $this->logo;
    }
}
