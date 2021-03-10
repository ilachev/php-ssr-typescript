<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Categories\Category;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class CategoryRepository
{
    private ObjectRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Category::class);
        $this->em = $em;
    }

    public function get(Id $id): Category
    {
        if (!$category = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Category is not found.');
        }

        return $category;
    }

    public function add(Category $category): void
    {
        $this->em->persist($category);
    }

    public function remove(Category $category): void
    {
        $this->em->remove($category);
    }
}
