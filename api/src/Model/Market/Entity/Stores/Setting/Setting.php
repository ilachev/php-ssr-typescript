<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Stores\Setting;

use App\Model\Market\Entity\Stores\Setting\Template\Template;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="market_stores_settings")
 */
class Setting
{
    public const PRIMARY = 'bbf53b31-84da-4856-a262-bb5549451b4e';

    /**
     * @ORM\Column(type="market_stores_setting_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Embedded(class="App\Model\Market\Entity\Stores\Setting\Template\Template")
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
