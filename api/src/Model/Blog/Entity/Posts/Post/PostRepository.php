<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Posts\Post;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class PostRepository
{
    private ObjectRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Post::class);
        $this->em = $em;
    }

    public function get(Id $id): Post
    {
        if (!$post = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Post is not found.');
        }

        return $post;
    }

    public function add(Post $post): void
    {
        $this->em->persist($post);
    }

    public function remove(Post $post): void
    {
        $this->em->remove($post);
    }
}
