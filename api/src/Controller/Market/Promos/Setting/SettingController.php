<?php

declare(strict_types=1);

namespace App\Controller\Market\Promos\Setting;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Market\Entity\Promos\Setting\Setting;
use App\Model\Market\UseCase\Promos\Setting\Edit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/market/promos/setting/{id}', name: 'market.promos.setting')]
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
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS');

        return $this->render('app/market/promos/setting/show.html.twig', compact('setting'));
    }

    #[Route('/edit', name: '.edit', requirements: ['id' => Guid::PATTERN])]
    public function edit(Setting $setting, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MARKET_MANAGE_PROMOS');

        $command = Edit\Command::fromSetting($setting);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('market.promos.setting.show', ['id' => $setting->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/market/promos/setting/edit.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }
}
