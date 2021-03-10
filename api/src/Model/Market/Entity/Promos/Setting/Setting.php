<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Setting;

use App\Model\Market\Entity\Promos\Setting\Template\Template;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="market_promos_settings")
 */
class Setting
{
    public const PRIMARY = '39a86956-122c-487a-88cc-66dd5b50e124';

    /**
     * @ORM\Column(type="market_promos_setting_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Embedded(class="App\Model\Market\Entity\Promos\Setting\Template\Template")
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
