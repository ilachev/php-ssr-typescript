<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Categories\Category;

use App\Model\AggregateRoot;
use App\Model\EventsTrait;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Categories\Category\Event\CategoryLogoRemoved;
use App\Model\Market\Entity\Categories\Category\Logo\Logo;
use App\Model\Market\Entity\Stores\Store\Store;
use App\Model\SeoProcessable;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="market_categories_categories", indexes={
 *     @ORM\Index(columns={"date", "sort"})
 * })
 */
class Category implements AggregateRoot, SeoProcessable
{
    use EventsTrait;

    /**
     * @ORM\Column(type="market_categories_category_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\ManyToMany(targetEntity="App\Model\Market\Entity\Stores\Store\Store", inversedBy="categories")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private Collection $stores;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Market\Entity\Author\Author")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Author $author;
    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Model\Market\Entity\Categories\Category\Logo\Logo",
     *     mappedBy="category",
     *     orphanRemoval=true,
     *     cascade={"all"}
     * )
     */
    private ?Logo $logo = null;
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
     * @ORM\Column(type="market_categories_category_status", length=16, options={"default" : Status::ACTIVE})
     */
    private Status $status;
    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private int $sort;
    /**
     * @ORM\OneToMany(
     *     targetEntity="Category",
     *     mappedBy="parent"
     * )
     */
    private Collection $children;
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private ?Category $parent = null;
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
        ?Category $parent = null,
        ?string $description = null
    ) {
        $this->id = $id;
        $this->author = $author;
        $this->name = $name;
        $this->description = $description;
        $this->date = $date;
        $this->slug = $slug;
        $this->seo = $seo;
        $this->meta = $meta;
        $this->sort = $sort;
        $this->parent = $parent;
        $this->status = new Status(Status::ACTIVE);
        $this->stores = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function edit(
        string $name,
        string $slug,
        Seo $seo,
        Meta $meta,
        int $sort,
        ?Category $parent = null,
        ?string $description = null
    ): void {
        $this->name = $name;
        $this->slug = $slug;
        $this->seo = $seo;
        $this->meta = $meta;
        $this->sort = $sort;
        $this->parent = $parent;
        $this->description = $description;
        $this->updateDate = new DateTimeImmutable();
    }

    public function archive(): void
    {
        if ($this->status->isArchived()) {
            throw new \DomainException('Категория уже в архиве.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->status->isActive()) {
            throw new \DomainException('Категория уже активна.');
        }
        $this->status = Status::active();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function getLogo(): ?Logo
    {
        return $this->logo;
    }

    public function setLogo(Logo $logo): void
    {
        $this->logo = $logo;
    }

    public function removeLogo(Logo $logo): void
    {
        $this->logo = null;
        $this->recordEvent(new CategoryLogoRemoved($logo->getInfo()));
    }

    public function addStore(Store $store): void
    {
        if (!$this->stores->contains($store)) {
            $this->stores->add($store);
        }
    }

    public function removeStore(Store $store): void
    {
        if ($this->stores->contains($store)) {
            $this->stores->removeElement($store);
        }
    }

    public function addChildren(Category $children): void
    {
        if (!$this->children->contains($children)) {
            $this->children->add($children);
        }
    }

    public function removeChildren(Category $children): void
    {
        if ($this->children->contains($children)) {
            $this->children->removeElement($children);
        }
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): ?string
    {
        return $this->description;
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

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }
}
