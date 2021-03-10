<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Author;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="market_authors")
 */
class Author
{
    /**
     * @ORM\Column(type="market_author_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private DateTimeImmutable $updateDate;
    /**
     * @ORM\Embedded(class="Name")
     */
    private Name $name;
    /**
     * @ORM\Column(type="market_author_email")
     */
    private ?Email $email = null;
    /**
     * @ORM\Column(type="market_author_status", length=16)
     */
    private Status $status;
    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Market\Entity\Stores\Store\Comment\Comment",
     *     mappedBy="author"
     * )
     */
    private Collection $comments;
    /**
     * @ORM\Version()
     * @ORM\Column(type="integer")
     */
    private int $version;

    public function __construct(Id $id, Name $name, Email $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->date = new DateTimeImmutable();
        $this->status = Status::active();
        $this->comments = new ArrayCollection();
    }

    public function edit(Name $name, Email $email): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->updateDate = new DateTimeImmutable();
    }

    public function archive(): void
    {
        if ($this->status->isArchived()) {
            throw new \DomainException('Автор уже в архиве.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->status->isActive()) {
            throw new \DomainException('Автор уже активен.');
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

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }
}
