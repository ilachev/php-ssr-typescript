<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Comment\Create;

use App\Model\Flusher;
use App\Model\Market\Entity\Author\AuthorRepository;
use App\Model\Market\Entity\Author\Id as AuthorId;
use App\Model\Market\Entity\Stores\Store\Comment\Comment;
use App\Model\Market\Entity\Stores\Store\Comment\CommentRepository;
use App\Model\Market\Entity\Stores\Store\Comment\Id;
use App\Model\Market\Entity\Stores\Store\Id as StoreId;
use App\Model\Market\Entity\Stores\Store\StoreRepository;
use DateTimeImmutable;
use Symfony\Component\Security\Core\Security;

class Handler
{
    public function __construct(
        private Security $auth,
        private AuthorRepository $authors,
        private CommentRepository $comments,
        private StoreRepository $stores,
        private Flusher $flusher,
    ) {
    }

    public function handle(Command $command): void
    {
        $store = $this->stores->get(new StoreId($command->storeId));
        $author = $this->authors->get(new AuthorId($this->auth->getUser()->getId()));

        $comment = Comment::create(
            Id::next(),
            $store,
            $author,
            new DateTimeImmutable(),
            $command->text,
            null !== $command->parentId ? $this->comments->get(new Id($command->parentId)) : null
        );

        $this->comments->add($comment);

        $this->flusher->flush($comment);
    }
}
