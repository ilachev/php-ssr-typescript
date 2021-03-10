<?php

declare(strict_types=1);

namespace App\Controller\Market\Stores\Store;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Market\Entity\Stores\Store\Store;
use App\Model\Market\UseCase\Stores\Store\Archive;
use App\Model\Market\UseCase\Stores\Store\Edit;
use App\Model\Market\UseCase\Stores\Store\Reinstate;
use App\Model\Market\UseCase\Stores\Store\Remove;
use App\Service\Uploader\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/stores/store/{id}', name: 'market.stores.store')]
class StoreController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '.show', requirements: ['id' => Guid::PATTERN])]
    public function show(Store $store): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES', $store);

        return $this->render('app/market/stores/store/show.html.twig', compact('store'));
    }

    #[Route('/edit', name: '.edit', requirements: ['id' => Guid::PATTERN])]
    public function edit(Store $store, Request $request, Edit\Handler $handler, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES', $store);

        $command = Edit\Command::fromStore($store);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get('logo')->getData();
            if ($logo) {
                $uploaded = $uploader->upload($logo);
                $file = new Edit\Logo(
                    $uploaded->getPath(),
                    $uploaded->getName(),
                    $uploaded->getSize()
                );
                $command->logo = $file;
            }

            try {
                $handler->handle($command);

                return $this->redirectToRoute('market.stores.store.show', ['id' => $store->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/market/stores/store/edit.html.twig', [
            'store' => $store,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Store $store, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('market.stores.store.show', ['id' => $store->getId()]);
        }

        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES', $store);

        $command = new Remove\Command($store->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.stores');
    }

    #[Route('/archive', name: '.archive', methods: ['POST'])]
    public function archive(Store $store, Request $request, Archive\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES');

        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('market.stores.store.show', ['id' => $store->getId()]);
        }

        $command = new Archive\Command($store->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.stores.store.show', ['id' => $store->getId()]);
    }

    #[Route('/reinstate', name: '.reinstate', methods: ['POST'])]
    public function reinstate(Store $store, Request $request, Reinstate\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES');

        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('market.stores.store.show', ['id' => $store->getId()]);
        }

        $command = new Reinstate\Command($store->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.stores.store.show', ['id' => $store->getId()]);
    }
}
