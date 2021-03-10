<?php

declare(strict_types=1);

namespace App\Controller\Market\Categories\Category;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Market\Entity\Categories\Category\Category;
use App\Model\Market\UseCase\Categories\Category\Archive;
use App\Model\Market\UseCase\Categories\Category\Edit;
use App\Model\Market\UseCase\Categories\Category\Reinstate;
use App\Model\Market\UseCase\Categories\Category\Remove;
use App\Service\Uploader\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/categories/category/{id}', name: 'market.categories.category')]
class CategoryController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '.show', requirements: ['id' => Guid::PATTERN])]
    public function show(Category $category): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_CATEGORIES', $category);

        return $this->render('app/market/categories/category/show.html.twig', compact('category'));
    }

    #[Route('/edit', name: '.edit', requirements: ['id' => Guid::PATTERN])]
    public function edit(Category $category, Request $request, Edit\Handler $handler, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_CATEGORIES', $category);

        $command = Edit\Command::fromCategory($category);

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

                return $this->redirectToRoute('market.categories.category.show', ['id' => $category->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/market/categories/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete", name=".delete", methods={"POST"})
     */
    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Category $category, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('market.categories.category.show', ['id' => $category->getId()]);
        }

        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_CATEGORIES', $category);

        $command = new Remove\Command($category->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.categories');
    }

    #[Route('/archive', name: '.archive', methods: ['POST'])]
    public function archive(Category $category, Request $request, Archive\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_CATEGORIES');

        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('market.categories.category.show', ['id' => $category->getId()]);
        }

        $command = new Archive\Command($category->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.categories.category.show', ['id' => $category->getId()]);
    }

    #[Route('/reinstate', name: '.reinstate', methods: ['POST'])]
    public function reinstate(Category $category, Request $request, Reinstate\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_CATEGORIES');

        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('market.categories.category.show', ['id' => $category->getId()]);
        }

        $command = new Reinstate\Command($category->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('market.categories.category.show', ['id' => $category->getId()]);
    }
}
