<?php

namespace App\Model\Blog\Entity\Posts\Post\Comment;

use App\Model\AggregateRoot;
use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\Entity\Posts\Post;
use App\Model\EventsTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity()
 * @ORM\Table(name="blog_posts_post_comments", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class Comment implements AggregateRoot
{
    use EventsTrait;

    /**
     * @ORM\Column(type="blog_posts_post_comment_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Blog\Entity\Posts\Post\Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     */
    private Post\Post $post;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Blog\Entity\Author\Author", inversedBy="comments")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Author $author;
    /**
     * @ORM\Column(type="blog_posts_post_comment_status", length=16, options={"default" : Status::DRAFT})
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
        Post\Post $post,
        Author $author,
        DateTimeImmutable $date,
        string $text,
        ?Comment $parent = null,
    ) {
        $this->id = $id;
        $this->post = $post;
        $this->author = $author;
        $this->date = $date;
        $this->parent = $parent;
        $this->text = $text;
        $this->status = new Status(Status::DRAFT);
        $this->children = new ArrayCollection();
    }

    public static function create(
        Id $id,
        Post\Post $post,
        Author $author,
        DateTimeImmutable $date,
        string $text,
        ?Comment $parent = null,
    ): self {
        $comment = new self($id, $post, $author, $date, $text, $parent);

        $comment->recordEvent(
            new Post\Event\PostCommentCreated(
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

    public function getPost(): Post\Post
    {
        return $this->post;
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
