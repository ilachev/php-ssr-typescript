<?php

declare(strict_types=1);

namespace App\Controller\Api\Blog\Posts;

use App\Controller\Api\PaginationSerializer;
use App\Model\Blog\Entity\Author\AuthorRepository;
use App\Model\Blog\Entity\Author\Id;
use App\Model\Blog\Entity\Categories\Category\Category;
use App\Model\Blog\Entity\Posts\Post\Comment\Comment;
use App\Model\Blog\Entity\Posts\Post\Post;
use App\Model\EntityNotFoundException;
use App\ReadModel\Blog\Posts\Post\Filter;
use App\ReadModel\Blog\Posts\Post\PostFetcher;
use App\Service\Blog\PreviewDescriptionFormatter;
use App\Service\Blog\SeoProcessor\PostProcessor;
use App\Service\Gravatar;
use App\Service\PluralWordForm;
use App\Service\Uploader\FileUploader;
use DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PostsController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private DenormalizerInterface $denormalizer,
        private FileUploader $uploader,
    ) {
    }

    #[Route('/blog/posts', name: 'blog.posts', methods: ['GET'])]
    public function index(Request $request, PostFetcher $fetcher): Response
    {
        $filter = Filter\Filter::all();

        /** @var Filter\Filter $filter */
        $filter = $this->denormalizer->denormalize(
            $request->query->get('filter', []), Filter\Filter::class, 'json', [
            'object_to_populate' => $filter,
            'ignored_attributes' => ['author'],
        ]);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            $request->query->getInt('per_page', self::PER_PAGE),
            $request->query->get('sort', 'date'),
            $request->query->get('direction', 'asc')
        );

        return $this->json([
            'items' => array_map(function (array $item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'status' => $item['status'],
                    'description' => PreviewDescriptionFormatter::format($item['description']),
                    'slug' => $item['slug'],
                    'date' => (new \IntlDateFormatter(
                        'ru_Ru',
                        \IntlDateFormatter::NONE,
                        \IntlDateFormatter::NONE,
                        null,
                        null,
                        "d MMMM y 'в' HH:mm"
                    ))->format(new DateTimeImmutable($item['date'])),
                    'date_atom' => (new \DateTimeImmutable($item['date']))->format(DATE_ATOM),
                    'logo' => [
                        'id' => $item['post_logo_id'],
                        'url' => $this->uploader->generateUrl($item['post_logo_info_path']),
                        'name' => $item['post_logo_info_name'],
                    ],
                    'category' => [
                        'slug' => $item['post_category_slug'],
                    ],
                    'comments' => [
                        'count' => $item['comments_count'],
                        'info' => 0 < $item['comments_count'] ?
                            PluralWordForm::format(
                                $item['comments_count'],
                                ['комментарий', 'комментария', 'комментариев'],
                            ) :
                            'комментариев нет',
                    ],
                    'author' => [
                        'name' => $item['author_name'],
                        'avatar' => Gravatar::url($item['author_email'], 40),
                    ],
                ];
            }, (array) $pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }

    /**
     * @ParamConverter("category", options={"mapping": {"categorySlug" = "slug"}})
     * @ParamConverter("post", options={"mapping": {"postSlug" = "slug"}})
     */
    #[Route('/blog/categories/{categorySlug}/posts/{postSlug}', name: 'blog.posts.post.show', methods: ['GET'])]
    public function show(Category $category, Post $post, AuthorRepository $authors): Response
    {
        $author = null;

        try {
            if ($id = $this->getUser()?->getId()) {
                $author = $authors->get(new Id($id));
            }
        } catch (EntityNotFoundException) {
            $author = null;
        }

        $commentsCount = $post->getComments()->filter(static function (Comment $comment) use ($author) {
            if (null !== $author) {
                return $author->getId()->isEqual($comment->getAuthor()->getId());
            }

            return $comment->isApproved();
        })->count();

        return $this->json([
            'id' => $post->getId()->getValue(),
            'name' => $post->getName(),
            'description' => $post->getDescription(),
            'slug' => $post->getSlug(),
            'logo' => null !== $post->getLogo() ? [
                'id' => $post->getLogo()->getId()->getValue(),
                'url' => $this->uploader->generateUrl($post->getLogo()->getInfo()->getPath()),
                'name' => $post->getLogo()->getInfo()->getName(),
            ] : null,
            'date' => (new \IntlDateFormatter(
                'ru_Ru',
                \IntlDateFormatter::NONE,
                \IntlDateFormatter::NONE,
                null,
                null,
                "d MMMM y 'в' HH:mm"
            ))->format($post->getDate()),
            'date_atom' => $post->getDate()->format(DATE_ATOM),
            'category' => [
                'slug' => $category->getSlug(),
                'name' => $category->getName(),
            ],
            'comments' => [
                'count' => $commentsCount,
                'info' => 0 < $commentsCount ?
                    PluralWordForm::format(
                        $commentsCount,
                        ['комментарий', 'комментария', 'комментариев'],
                    ) :
                    'комментариев нет',
            ],
            'author' => [
                'name' => $post->getAuthor()->getName()->getFull(),
                'avatar' => Gravatar::url($post->getAuthor()->getEmail()->getValue(), 40),
            ],
        ]);
    }

    /**
     * @ParamConverter("category", options={"mapping": {"categorySlug" = "slug"}})
     * @ParamConverter("post", options={"mapping": {"postSlug" = "slug"}})
     */
    #[Route('/blog/categories/{categorySlug}/posts/{postSlug}/info', name: 'blog.posts.post.info', methods: ['GET'])]
    public function info(Category $category, Post $post, PostProcessor $processor): Response
    {
        return $this->json($processor->process($post));
    }
}
