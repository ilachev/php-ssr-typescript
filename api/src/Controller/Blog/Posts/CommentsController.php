<?php

namespace App\Controller\Blog\Posts;

use App\Controller\ErrorHandler;
use App\ReadModel\Blog\Posts\Comments\CommentsFetcher;
use App\ReadModel\Blog\Posts\Comments\Filter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/posts/comments', name: 'blog.posts.comments')]
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
        $this->denyAccessUnlessGranted('ROLE_BLOG_MANAGE_POSTS');

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

        return $this->render('app/blog/posts/comments/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
}
