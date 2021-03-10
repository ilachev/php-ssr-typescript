<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Stores\Setting;

use App\Model\Market\Entity\Stores\Setting\Setting;
use Doctrine\ORM\EntityManagerInterface;

class SettingFetcher
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function find(string $id): ?Setting
    {
        return $this->em->getRepository(Setting::class)->find($id);
    }
}
