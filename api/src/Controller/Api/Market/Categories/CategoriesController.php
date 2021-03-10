<?php

declare(strict_types=1);

namespace App\Controller\Api\Market\Categories;

use App\Controller\Api\PaginationSerializer;
use App\Model\Market\Entity\Categories\Category\Category;
use App\ReadModel\Market\Categories\Category\CategoryFetcher;
use App\ReadModel\Market\Categories\Category\Filter;
use App\Service\Market\SeoProcessor\CategoryProcessor;
use App\Service\Uploader\FileUploader;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CategoriesController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private DenormalizerInterface $denormalizer,
        private FileUploader $uploader,
    ) {
    }

    #[Route('/market/categories', name: 'market.categories', methods: ['GET'])]
    public function index(Request $request, CategoryFetcher $fetcher): Response
    {
        $filter = Filter\Filter::all();

        /** @var Filter\Filter $filter */
        $filter = $this->denormalizer->denormalize(
            $request->query->get('filter', []), Filter\Filter::class, 'array', [
                'object_to_populate' => $filter,
                'ignored_attributes' => ['author'],
        ]);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'sort'),
            $request->query->get('direction', 'asc')
        );

        return $this->json([
            'items' => array_map(function (array $item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'logo' => [
                        'id' => $item['category_logo_id'],
                        'url' => $this->uploader->generateUrl($item['category_logo_info_path']),
                        'name' => $item['category_logo_info_name'],
                    ],
                ];
            }, (array) $pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }

    #[Route('/market/categories/{slug}', name: 'market.categories.category.show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->json([
            'id' => $category->getId()->getValue(),
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            'slug' => $category->getSlug(),
            'logo' => null !== $category->getLogo() ? [
                'id' => $category->getLogo()->getId()->getValue(),
                'url' => $this->uploader->generateUrl($category->getLogo()->getInfo()->getPath()),
                'name' => $category->getLogo()->getInfo()->getName(),
            ] : null,
        ]);
    }

    #[Route('/market/categories/{slug}/info', name: 'market.categories.category.info', methods: ['GET'])]
    public function info(Category $category, CategoryProcessor $processor): Response
    {
        return $this->json($processor->process($category));
    }
}

/*
 * @OA\Get(
 *     path="/market/categories",
 *     tags={"Market categories"},
 *     @OA\Parameter(
 *         name="filter[name]",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         style="form"
 *     ),
 *     @OA\Parameter(
 *         name="filter[status]",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         style="form"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="items", type="array", @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="string"),
 *                 @OA\Property(property="name", type="string"),
 *             )),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination"),
 *         )
 *     )
 * )
 */
