<?php

declare(strict_types=1);

namespace App\Controller\Blog\Posts\Post;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Blog\Entity\Posts\Post\Post;
use App\Model\Blog\UseCase\Posts\Post\Archive;
use App\Model\Blog\UseCase\Posts\Post\Edit;
use App\Model\Blog\UseCase\Posts\Post\Reinstate;
use App\Model\Blog\UseCase\Posts\Post\Remove;
use App\Service\Uploader\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/posts/post/{id}', name: 'blog.posts.post')]
class PostController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '.show', requirements: ['id' => Guid::PATTERN])]
    public function show(Post $post): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS', $post);

        return $this->render('app/blog/posts/post/show.html.twig', compact('post'));
    }

    #[Route('/edit', name: '.edit', requirements: ['id' => Guid::PATTERN])]
    public function edit(Post $post, Request $request, Edit\Handler $handler, FileUploader $uploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS', $post);

        $command = Edit\Command::fromPost($post);

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

                return $this->redirectToRoute('blog.posts.post.show', ['id' => $post->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/blog/posts/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Post $post, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.posts.post.show', ['id' => $post->getId()]);
        }

        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS', $post);

        $command = new Remove\Command($post->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.posts');
    }

    #[Route('/archive', name: '.archive', methods: ['POST'])]
    public function archive(Post $post, Request $request, Archive\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS');

        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.posts.post.show', ['id' => $post->getId()]);
        }

        $command = new Archive\Command($post->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.posts.post.show', ['id' => $post->getId()]);
    }

    #[Route('/reinstate', name: '.reinstate', methods: ['POST'])]
    public function reinstate(Post $post, Request $request, Reinstate\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS');

        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.posts.post.show', ['id' => $post->getId()]);
        }

        $command = new Reinstate\Command($post->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.posts.post.show', ['id' => $post->getId()]);
    }
}
