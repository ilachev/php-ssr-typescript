<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Promos\Promo;

use App\Model\EntityNotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class PromoRepository
{
    private ObjectRepository $repo;
    private Connection $connection;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Promo::class);
        $this->connection = $em->getConnection();
        $this->em = $em;
    }

    public function get(Id $id): Promo
    {
        if (!$promo = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Promo is not found.');
        }

        return $promo;
    }

    public function add(Promo $promo): void
    {
        $this->em->persist($promo);
    }

    public function remove(Promo $promo): void
    {
        $this->em->remove($promo);
    }

    public function nextId(): Id
    {
        return new Id((int) $this->connection->query('SELECT nextval(\'market_promos_promo_seq\')')->fetchColumn());
    }
}
