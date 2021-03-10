<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Blog\Entity\Author\Author;
use App\Model\Blog\UseCase\Author\Archive;
use App\Model\Blog\UseCase\Author\Create;
use App\Model\Blog\UseCase\Author\Edit;
use App\Model\Blog\UseCase\Author\Reinstate;
use App\Model\User\Entity\User\User;
use App\ReadModel\Blog\Author\AuthorFetcher;
use App\ReadModel\Blog\Author\Filter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_BLOG_MANAGE_AUTHORS")
 */
#[Route('/blog/authors', name: 'blog.authors')]
class AuthorsController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private ErrorHandler $errors,
    ) {
    }

    #[Route('', name: '')]
    public function index(Request $request, AuthorFetcher $fetcher): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_AUTHORS');

        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/blog/authors/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create/{id}', name: '.create')]
    public function create(User $user, Request $request, AuthorFetcher $authors, Create\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_AUTHORS');

        if ($authors->exists($user->getId()->getValue())) {
            $this->addFlash('error', 'Author already exists.');

            return $this->redirectToRoute('users.show', ['id' => $user->getId()]);
        }

        $command = new Create\Command($user->getId()->getValue());
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();
        $command->email = $user->getEmail() ? $user->getEmail()->getValue() : null;

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('blog.authors.show', ['id' => $user->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/blog/authors/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: '.edit')]
    public function edit(Author $author, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_AUTHORS');

        $command = Edit\Command::fromAuthor($author);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                return $this->redirectToRoute('blog.authors.show', ['id' => $author->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/blog/authors/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/archive', name: '.archive', methods: ['POST'])]
    public function archive(Author $author, Request $request, Archive\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_AUTHORS');

        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.authors.show', ['id' => $author->getId()]);
        }

        $command = new Archive\Command($author->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.authors.show', ['id' => $author->getId()]);
    }

    #[Route('/{id}/reinstate', name: '.reinstate', methods: ['POST'])]
    public function reinstate(Author $author, Request $request, Reinstate\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_AUTHORS');

        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('blog.authors.show', ['id' => $author->getId()]);
        }

        if ($author->getId()->getValue() === $this->getUser()->getId()) {
            $this->addFlash('error', 'Unable to reinstate yourself.');

            return $this->redirectToRoute('blog.authors.show', ['id' => $author->getId()]);
        }

        $command = new Reinstate\Command($author->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('blog.authors.show', ['id' => $author->getId()]);
    }

    #[Route('/{id}', name: '.show', requirements: ['id' => Guid::PATTERN])]
    public function show(Author $author): Response
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_AUTHORS');

        return $this->render('app/blog/authors/show.html.twig', compact('author'));
    }
}
