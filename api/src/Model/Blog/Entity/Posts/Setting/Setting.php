<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Posts\Setting;

use App\Model\Blog\Entity\Posts\Setting\Template\Template;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_posts_settings")
 */
class Setting
{
    public const PRIMARY = '88cb39db-9ea1-48c5-86c1-1b2e7c98fab5';

    /**
     * @ORM\Column(type="blog_posts_setting_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Embedded(class="App\Model\Blog\Entity\Posts\Setting\Template\Template")
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
