<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Posts\Setting;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class SettingRepository
{
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Setting::class);
    }

    public function get(Id $id): Setting
    {
        if (!$category = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Setting is not found.');
        }

        return $category;
    }
}
