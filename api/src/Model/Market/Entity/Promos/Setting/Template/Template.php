<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Setting\Template;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Template
{
    /**
     * @ORM\Embedded(class="Seo")
     */
    private Seo $seo;

    public function __construct(Seo $seo)
    {
        $this->seo = $seo;
    }

    public function getSeo(): Seo
    {
        return $this->seo;
    }
}
