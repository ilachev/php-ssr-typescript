<?php

declare(strict_types=1);

namespace App\Controller\Blog\Categories;

use App\Controller\ErrorHandler;
use App\Model\Blog\UseCase\Categories\Category\Create;
use App\ReadModel\Blog\Categories\Category\CategoryFetcher;
use App\ReadModel\Blog\Categories\Category\Filter;
use App\Service\Uploader\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/categories', name: 'blog.categories')]
class CategoriesController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '')]
    public function index(Request $request, CategoryFetcher $fetcher): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_CATEGORIES');

        $filter = Filter\Filter::all();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/blog/categories/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create', name: '.create')]
    public function create(Request $request, Create\Handler $handler, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_CATEGORIES');

        $command = new Create\Command($this->getUser()->getId());

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('blog.categories');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/blog/categories/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
