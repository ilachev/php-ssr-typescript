<?php

namespace App\Controller\Market\Stores\Store;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Market\Entity\Stores\Store\Comment\Comment;
use App\Model\Market\UseCase\Stores\Store;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/stores/store/comment/{id}', name: 'market.stores.store.comment')]
class CommentController extends AbstractController
{
    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '.show', requirements: ['id' => Guid::PATTERN])]
    public function show(Comment $comment): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES');

        return $this->render('app/market/stores/store/comment/show.html.twig', compact('comment'));
    }

    #[Route('/draft', name: '.draft', methods: ['POST'])]
    public function draft(Comment $comment, Request $request, Store\Comment\Draft\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES');

        if (!$this->isCsrfTokenValid('draft', $request->request->get('token'))) {
            return $this->redirectToRoute('market.stores.store.comment.show', ['id' => $comment->getId()]);
        }

        $command = new Store\Comment\Draft\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.stores.store.comment.show', ['id' => $comment->getId()]);
    }

    #[Route('/approve', name: '.approve', methods: ['POST'])]
    public function approve(Comment $comment, Request $request, Store\Comment\Approve\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES');

        if (!$this->isCsrfTokenValid('approve', $request->request->get('token'))) {
            return $this->redirectToRoute('market.stores.store.comment.show', ['id' => $comment->getId()]);
        }

        $command = new Store\Comment\Approve\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.stores.store.comment.show', ['id' => $comment->getId()]);
    }

    #[Route('/decline', name: '.decline', methods: ['POST'])]
    public function decline(Comment $comment, Request $request, Store\Comment\Decline\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES');

        if (!$this->isCsrfTokenValid('decline', $request->request->get('token'))) {
            return $this->redirectToRoute('market.stores.store.comment.show', ['id' => $comment->getId()]);
        }

        $command = new Store\Comment\Decline\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.stores.store.comment.show', ['id' => $comment->getId()]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Comment $comment, Request $request, Store\Comment\Remove\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES');

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('market.stores.store.comment.show', ['id' => $comment->getId()]);
        }

        $command = new Store\Comment\Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.stores.comments');
    }
}
