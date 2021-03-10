<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Promo;

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

    public function __construct(?string $heading = null)
    {
        $this->heading = $heading;
    }

    public function getHeading(): ?string
    {
        return $this->heading;
    }
}
