<?php

declare(strict_types=1);

namespace App\ReadModel\Market\Categories\Setting;

use App\Model\Market\Entity\Categories\Setting\Setting;
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
