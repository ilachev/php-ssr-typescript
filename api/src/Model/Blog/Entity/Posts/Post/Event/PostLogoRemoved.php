<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Posts\Post\Event;

use App\Model\Blog\Entity\Posts\Post\Logo\Info;

class PostLogoRemoved
{
    public Info $info;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }
}
