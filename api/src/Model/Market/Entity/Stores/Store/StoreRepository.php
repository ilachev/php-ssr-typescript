<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Stores\Store;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class StoreRepository
{
    private ObjectRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Store::class);
        $this->em = $em;
    }

    public function get(Id $id): Store
    {
        if (!$store = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Магазин не найден.');
        }

        return $store;
    }

    public function add(Store $store): void
    {
        $this->em->persist($store);
    }

    public function remove(Store $store): void
    {
        $this->em->remove($store);
    }
}
