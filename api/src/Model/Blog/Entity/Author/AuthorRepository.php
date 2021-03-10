<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Author;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class AuthorRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function has(Id $id): bool
    {
        return $this->em->getRepository(Author::class)->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Author
    {
        if (!$author = $this->em->getRepository(Author::class)->find($id->getValue())) {
            throw new EntityNotFoundException('Автор не найден.');
        }

        return $author;
    }

    public function add(Author $author): void
    {
        $this->em->persist($author);
    }
}
