<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Stores\Store\Event;

use App\Model\Market\Entity\Stores\Store\Logo\Info;

class StoreLogoRemoved
{
    public Info $info;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }
}
