<?php

namespace App\Controller\Api\Market\Stores;

use App\Controller\Api\PaginationSerializer;
use App\Model\Market\UseCase\Stores\Store\Comment;
use App\ReadModel\Market\Stores\Comments\CommentsFetcher;
use App\ReadModel\Market\Stores\Comments\Filter;
use ReCaptcha\ReCaptcha;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommentsController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private DenormalizerInterface $denormalizer,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/market/stores/comments/index', name: 'market.stores.store.comments.show', methods: ['GET'])]
    public function index(Request $request, CommentsFetcher $fetcher): Response
    {
        $filter = Filter\Filter::all();

        /** @var Filter\Filter $filter */
        $filter = $this->denormalizer->denormalize(
            $request->query->get('filter', []), Filter\Filter::class, 'json', [
            'object_to_populate' => $filter,
            'ignored_attributes' => ['author'],
        ]);

        $pagination = $fetcher->allTree(
            $filter,
            $request->query->getInt('page', 1),
            $request->query->getInt('per_page', self::PER_PAGE),
            $request->query->get('sort', 'date'),
            $request->query->get('direction', 'asc')
        );

        return $this->json([
            'items' => array_map(static function (array $elem) {
                return [
                    'id' => $elem['id'],
                    'text' => $elem['text'],
                    'level' => $elem['level'],
                    'parent_id' => $elem['parent_id'],
                    'author_id' => $elem['author_id'],
                    'author_name' => $elem['author_name'],
                    'avatar' => $elem['avatar'],
                    'date' => $elem['date'],
                    'user_role' => $elem['user_role'],
                    'children' => $elem['children'],
                ];
            }, (array) $pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }

    #[Route('/market/stores/comments/count', name: 'market.stores.store.comments.count', methods: ['GET'])]
    public function count(Request $request, CommentsFetcher $fetcher): Response
    {
        $filter = Filter\Filter::all();

        /** @var Filter\Filter $filter */
        $filter = $this->denormalizer->denormalize(
            $request->query->get('filter', []), Filter\Filter::class, 'json', [
            'object_to_populate' => $filter,
            'ignored_attributes' => ['author'],
        ]);

        return $this->json([
            'count' => array_sum(
                array_map(
                    static fn (array $elem) => $elem['count'],
                    $fetcher->allCount($filter)
                )
            ),
        ]);
    }

    #[Route('/market/stores/comments/create', name: 'market.stores.store.comments.create', methods: ['POST'])]
    public function create(Request $request, Comment\Create\Handler $handler, ReCaptcha $captcha): Response
    {
        /** @var Comment\Create\Command $command */
        $command = $this->serializer->deserialize(
            $request->getContent(),
            Comment\Create\Command::class,
            'json'
        );

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            return $this->json([
                'errors' => $violations,
                'data' => $command,
                'status' => 'error',
            ], 400);
        }

        $resp = $captcha->verify($command->token);
        if (!$resp->isSuccess()) {
            return $this->json([
                'errors' => [
                    'violations' => [
                        [
                            'propertyPath' => 'token',
                            'title' => '',
                        ],
                    ],
                ],
                'data' => $command,
                'status' => 'error',
            ], 400);
        }

        $handler->handle($command);

        return $this->json([
            'data' => new Comment\Create\Command(),
            'status' => 'success',
            'errors' => [
                'violations' => [],
            ],
        ], 201);
    }
}
