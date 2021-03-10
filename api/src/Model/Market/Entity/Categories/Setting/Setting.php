<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Categories\Setting;

use App\Model\Market\Entity\Categories\Setting\Template\Template;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="market_categories_settings")
 */
class Setting
{
    public const PRIMARY = 'cd88b8a0-72c5-444f-ac42-55fa1bfd17fd';

    /**
     * @ORM\Column(type="market_categories_setting_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Embedded(class="App\Model\Market\Entity\Categories\Setting\Template\Template")
     */
    private Template $template;
    /**
     * @ORM\Version()
     * @ORM\Column(type="integer")
     */
    private int $version;

    public function __construct(Id $id, Template $template)
    {
        $this->id = $id;
        $this->template = $template;
    }

    public function edit(Template $template): void
    {
        $this->template = $template;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getTemplate(): Template
    {
        return $this->template;
    }
}
