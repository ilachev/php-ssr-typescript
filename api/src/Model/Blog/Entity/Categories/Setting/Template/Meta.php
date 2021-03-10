<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Categories\Setting\Template;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Meta
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $title = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $ogTitle = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $ogDescription = null;

    public function __construct(
        ?string $title = null,
        ?string $description = null,
        ?string $ogTitle = null,
        ?string $ogDescription = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->ogTitle = $ogTitle;
        $this->ogDescription = $ogDescription;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getOgTitle(): ?string
    {
        return $this->ogTitle;
    }

    public function getOgDescription(): ?string
    {
        return $this->ogDescription;
    }
}
