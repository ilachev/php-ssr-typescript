<?php

declare(strict_types=1);

namespace App\Controller\Market;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/market', name: 'market')]
    public function index(): Response
    {
        return $this->redirectToRoute('market.stores');
    }
}
