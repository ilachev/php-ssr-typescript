<?php

namespace App\Controller\Market\Stores;

use App\Controller\ErrorHandler;
use App\ReadModel\Market\Stores\Comments\CommentsFetcher;
use App\ReadModel\Market\Stores\Comments\Filter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/stores/comments', name: 'market.stores.comments')]
class CommentsController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '')]
    public function index(Request $request, CommentsFetcher $fetcher): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_STORES');

        $filter = Filter\Filter::all();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'date'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/market/stores/comments/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
}
