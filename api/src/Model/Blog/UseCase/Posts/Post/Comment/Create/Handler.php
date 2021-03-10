<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Comment\Create;

use App\Model\Blog\Entity\Author\AuthorRepository;
use App\Model\Blog\Entity\Author\Id as AuthorId;
use App\Model\Blog\Entity\Posts\Post\Comment\Comment;
use App\Model\Blog\Entity\Posts\Post\Comment\CommentRepository;
use App\Model\Blog\Entity\Posts\Post\Comment\Id;
use App\Model\Blog\Entity\Posts\Post\Id as PostId;
use App\Model\Blog\Entity\Posts\Post\PostRepository;
use App\Model\Flusher;
use DateTimeImmutable;
use Symfony\Component\Security\Core\Security;

class Handler
{
    public function __construct(
        private Security $auth,
        private AuthorRepository $authors,
        private CommentRepository $comments,
        private PostRepository $posts,
        private Flusher $flusher,
    ) {
    }

    public function handle(Command $command): void
    {
        $post = $this->posts->get(new PostId($command->postId));
        $author = $this->authors->get(new AuthorId($this->auth->getUser()->getId()));

        $comment = Comment::create(
            Id::next(),
            $post,
            $author,
            new DateTimeImmutable(),
            $command->text,
            null !== $command->parentId ? $this->comments->get(new Id($command->parentId)) : null
        );

        $this->comments->add($comment);

        $this->flusher->flush($comment);
    }
}
