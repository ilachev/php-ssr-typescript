<?php

namespace App\Controller\Blog\Posts\Post;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Blog\Entity\Posts\Post\Comment\Comment;
use App\Model\Blog\UseCase\Posts\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/posts/post/comment/{id}', name: 'blog.posts.post.comment')]
class CommentController extends AbstractController
{
    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '.show', requirements: ['id' => Guid::PATTERN])]
    public function show(Comment $comment): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS');

        return $this->render('app/blog/posts/post/comment/show.html.twig', compact('comment'));
    }

    #[Route('/draft', name: '.draft', methods: ['POST'])]
    public function draft(Comment $comment, Request $request, Post\Comment\Draft\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS');

        if (!$this->isCsrfTokenValid('draft', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.posts.post.comment.show', ['id' => $comment->getId()]);
        }

        $command = new Post\Comment\Draft\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.posts.post.comment.show', ['id' => $comment->getId()]);
    }

    #[Route('/approve', name: '.approve', methods: ['POST'])]
    public function approve(Comment $comment, Request $request, Post\Comment\Approve\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS');

        if (!$this->isCsrfTokenValid('approve', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.posts.post.comment.show', ['id' => $comment->getId()]);
        }

        $command = new Post\Comment\Approve\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.posts.post.comment.show', ['id' => $comment->getId()]);
    }

    #[Route('/decline', name: '.decline', methods: ['POST'])]
    public function decline(Comment $comment, Request $request, Post\Comment\Decline\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS');

        if (!$this->isCsrfTokenValid('decline', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.posts.post.comment.show', ['id' => $comment->getId()]);
        }

        $command = new Post\Comment\Decline\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.posts.post.comment.show', ['id' => $comment->getId()]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Comment $comment, Request $request, Post\Comment\Remove\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS');

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.posts.post.comment.show', ['id' => $comment->getId()]);
        }

        $command = new Post\Comment\Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.posts.comments');
    }
}
