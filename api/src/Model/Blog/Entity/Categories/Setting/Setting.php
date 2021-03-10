<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Categories\Setting;

use App\Model\Blog\Entity\Categories\Setting\Template\Template;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_categories_settings")
 */
class Setting
{
    public const PRIMARY = '47226abe-4158-4f8a-b131-3933c8bb1b47';

    /**
     * @ORM\Column(type="blog_categories_setting_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Embedded(class="App\Model\Blog\Entity\Categories\Setting\Template\Template")
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
