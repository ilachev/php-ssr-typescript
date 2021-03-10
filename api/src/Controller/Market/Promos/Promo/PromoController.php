<?php

declare(strict_types=1);

namespace App\Controller\Market\Promos\Promo;

use App\Controller\ErrorHandler;
use App\Model\Market\Entity\Promos\Promo\Promo;
use App\Model\Market\UseCase\Promos\Promo\Archive;
use App\Model\Market\UseCase\Promos\Promo\Edit;
use App\Model\Market\UseCase\Promos\Promo\Reinstate;
use App\Model\Market\UseCase\Promos\Promo\Remove;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/promos/promo/{id}', name: 'market.promos.promo')]
class PromoController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '.show', requirements: ['id' => "\d+"])]
    public function show(Promo $promo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS', $promo);

        return $this->render('app/market/promos/promo/show.html.twig', compact('promo'));
    }

    #[Route('/edit', name: '.edit', requirements: ['id' => "\d+"])]
    public function edit(Promo $promo, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS', $promo);

        $command = Edit\Command::fromPromo($promo);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('market.promos.promo.show', ['id' => $promo->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/market/promos/promo/edit.html.twig', [
            'promo' => $promo,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Promo $promo, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('market.promos.promo.show', ['id' => $promo->getId()]);
        }

        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS', $promo);

        $command = new Remove\Command($promo->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.promos');
    }

    #[Route('/archive', name: '.archive', methods: ['POST'])]
    public function archive(Promo $promo, Request $request, Archive\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS');

        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('market.promos.promo.show', ['id' => $promo->getId()]);
        }

        $command = new Archive\Command($promo->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.promos.promo.show', ['id' => $promo->getId()]);
    }

    #[Route('/reinstate', name: '.reinstate', methods: ['POST'])]
    public function reinstate(Promo $promo, Request $request, Reinstate\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS');

        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('market.promos.promo.show', ['id' => $promo->getId()]);
        }

        $command = new Reinstate\Command($promo->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.promos.promo.show', ['id' => $promo->getId()]);
    }
}
