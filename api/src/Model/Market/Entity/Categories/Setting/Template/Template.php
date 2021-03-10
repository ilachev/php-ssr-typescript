<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Categories\Setting\Template;

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
    /**
     * @ORM\Embedded(class="Meta")
     */
    private Meta $meta;

    public function __construct(Seo $seo, Meta $meta)
    {
        $this->seo = $seo;
        $this->meta = $meta;
    }

    public function getSeo(): Seo
    {
        return $this->seo;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }
}
