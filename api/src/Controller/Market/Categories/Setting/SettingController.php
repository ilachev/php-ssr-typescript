<?php

declare(strict_types=1);

namespace App\Controller\Market\Categories\Setting;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Market\Entity\Categories\Setting\Setting;
use App\Model\Market\UseCase\Categories\Setting\Edit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/categories/setting/{id}', name: 'market.categories.setting')]
class SettingController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '.show', requirements: ['id' => Guid::PATTERN])]
    public function show(Setting $setting): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_CATEGORIES');

        return $this->render('app/market/categories/setting/show.html.twig', compact('setting'));
    }

    #[Route('/edit', name: '.edit', requirements: ['id' => Guid::PATTERN])]
    public function edit(Setting $setting, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_CATEGORIES');

        $command = Edit\Command::fromSetting($setting);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('market.categories.setting.show', ['id' => $setting->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/market/categories/setting/edit.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }
}
