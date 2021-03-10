<?php

namespace App\Model\Market\Entity\Stores\Store\Comment;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class CommentRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function get(Id $id): Comment
    {
        if (!$comment = $this->em->getRepository(Comment::class)->find($id->getValue())) {
            throw new EntityNotFoundException('Комментарий не найден.');
        }

        return $comment;
    }

    public function add(Comment $comment): void
    {
        $this->em->persist($comment);
    }

    public function remove(Comment $comment): void
    {
        $this->em->remove($comment);
    }
}
