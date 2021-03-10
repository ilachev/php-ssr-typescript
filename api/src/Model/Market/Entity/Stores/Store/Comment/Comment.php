<?php

namespace App\Model\Market\Entity\Stores\Store\Comment;

use App\Model\AggregateRoot;
use App\Model\EventsTrait;
use App\Model\Market\Entity\Author\Author;
use App\Model\Market\Entity\Stores\Store;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity()
 * @ORM\Table(name="market_stores_store_comments", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class Comment implements AggregateRoot
{
    use EventsTrait;

    /**
     * @ORM\Column(type="market_stores_store_comment_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Market\Entity\Stores\Store\Store", inversedBy="comments")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", nullable=false)
     */
    private Store\Store $store;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Market\Entity\Author\Author", inversedBy="comments")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Author $author;
    /**
     * @ORM\Column(type="market_stores_store_comment_status", length=16, options={"default" : Status::DRAFT})
     */
    private Status $status;
    /**
     * @ORM\OneToMany(
     *     targetEntity="Comment",
     *     mappedBy="parent"
     * )
     */
    private Collection $children;
    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private ?Comment $parent = null;
    /**
     * @ORM\Column(type="text")
     */
    private string $text;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private DateTimeImmutable $updateDate;
    /**
     * @ORM\Version()
     * @ORM\Column(type="integer")
     */
    private int $version;

    public function __construct(
        Id $id,
        Store\Store $store,
        Author $author,
        DateTimeImmutable $date,
        string $text,
        ?Comment $parent = null,
    ) {
        $this->id = $id;
        $this->store = $store;
        $this->author = $author;
        $this->date = $date;
        $this->parent = $parent;
        $this->text = $text;
        $this->status = new Status(Status::DRAFT);
        $this->children = new ArrayCollection();
    }

    public static function create(
        Id $id,
        Store\Store $store,
        Author $author,
        DateTimeImmutable $date,
        string $text,
        ?Comment $parent = null,
    ): self {
        $comment = new self($id, $store, $author, $date, $text, $parent);

        $comment->recordEvent(
            new Store\Event\PostCommentCreated(
                $id,
                $author,
                $text
            )
        );

        return $comment;
    }

    public function draft(): void
    {
        if ($this->status->isDraft()) {
            throw new \DomainException('Коммент уже в черновиках.');
        }
        $this->status = Status::draft();
    }

    public function decline(): void
    {
        if ($this->status->isDeclined()) {
            throw new \DomainException('Коммент уже отклонён.');
        }
        $this->status = Status::declined();
    }

    public function approve(): void
    {
        if ($this->status->isApproved()) {
            throw new \DomainException('Коммент уже принят.');
        }
        $this->status = Status::approved();
    }

    #[Pure]
    public function isDraft(): bool
    {
        return $this->status->isDraft();
    }

    #[Pure]
    public function isDeclined(): bool
    {
        return $this->status->isDeclined();
    }

    #[Pure]
    public function isApproved(): bool
    {
        return $this->status->isApproved();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getStore(): Store\Store
    {
        return $this->store;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function getParent(): ?Comment
    {
        return $this->parent;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
