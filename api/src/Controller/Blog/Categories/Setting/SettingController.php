<?php

declare(strict_types=1);

namespace App\Controller\Blog\Categories\Setting;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Blog\Entity\Categories\Setting\Setting;
use App\Model\Blog\UseCase\Categories\Setting\Edit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/categories/setting/{id}', name: 'blog.categories.setting')]
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
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_CATEGORIES');

        return $this->render('app/blog/categories/setting/show.html.twig', compact('setting'));
    }

    #[Route('/edit', name: '.edit', requirements: ['id' => Guid::PATTERN])]
    public function edit(Setting $setting, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_CATEGORIES');

        $command = Edit\Command::fromSetting($setting);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('blog.categories.setting.show', ['id' => $setting->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/blog/categories/setting/edit.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }
}
