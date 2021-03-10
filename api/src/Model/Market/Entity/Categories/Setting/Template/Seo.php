<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Categories\Setting\Template;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Seo
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $heading = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description = null;

    public function __construct(?string $heading = null, ?string $description = null)
    {
        $this->heading = $heading;
        $this->description = $description;
    }

    public function getHeading(): ?string
    {
        return $this->heading;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
