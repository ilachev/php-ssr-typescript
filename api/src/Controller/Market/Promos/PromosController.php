<?php

declare(strict_types=1);

namespace App\Controller\Market\Promos;

use App\Controller\ErrorHandler;
use App\Model\Market\UseCase\Promos\Promo\Create;
use App\ReadModel\Market\Promos\Promo\Filter;
use App\ReadModel\Market\Promos\Promo\PromoFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/promos', name: 'market.promos')]
class PromosController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '')]
    public function index(Request $request, PromoFetcher $fetcher): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS');

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

        return $this->render('app/market/promos/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create', name: '.create')]
    public function create(Request $request, Create\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS');

        $command = new Create\Command($this->getUser()->getId());

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('market.promos');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/market/promos/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
