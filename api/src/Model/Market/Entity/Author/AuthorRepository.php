<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Author;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class AuthorRepository
{
    private ObjectRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Author::class);
        $this->em = $em;
    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Author
    {
        if (!$author = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Автор не найден.');
        }

        return $author;
    }

    public function add(Author $author): void
    {
        $this->em->persist($author);
    }
}
