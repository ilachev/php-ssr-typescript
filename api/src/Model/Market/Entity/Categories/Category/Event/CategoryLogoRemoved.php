<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Categories\Category\Event;

use App\Model\Market\Entity\Categories\Category\Logo\Info;

class CategoryLogoRemoved
{
    public Info $info;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }
}
