<?php

declare(strict_types=1);

namespace App\Controller\Api\Market\Stores;

use App\Controller\Api\PaginationSerializer;
use App\Model\Market\Entity\Stores\Store\Store;
use App\ReadModel\Market\Stores\Store\Filter;
use App\ReadModel\Market\Stores\Store\StoreFetcher;
use App\Service\Market\SeoProcessor\StoreProcessor;
use App\Service\Uploader\FileUploader;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class StoresController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private DenormalizerInterface $denormalizer,
        private FileUploader $uploader,
    ) {
    }

    #[Route('/market/stores', name: 'market.stores', methods: ['GET'])]
    public function index(Request $request, StoreFetcher $fetcher): Response
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
                        'id' => $item['store_logo_id'],
                        'url' => $this->uploader->generateUrl($item['store_logo_info_path']),
                        'name' => $item['store_logo_info_name'],
                    ],
                ];
            }, (array) $pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }

    #[Route('/market/stores/{slug}', name: 'market.stores.store.show', methods: ['GET'])]
    public function show(Store $store): Response
    {
        return $this->json([
            'id' => $store->getId()->getValue(),
            'name' => $store->getName(),
            'info' => $store->getInfo(),
            'description' => $store->getDescription(),
            'slug' => $store->getSlug(),
            'logo' => null !== $store->getLogo() ? [
                'id' => $store->getLogo()->getId()->getValue(),
                'url' => $this->uploader->generateUrl($store->getLogo()->getInfo()->getPath()),
                'name' => $store->getLogo()->getInfo()->getName(),
            ] : null,
        ]);
    }

    #[Route('/market/stores/{slug}/info', name: 'market.stores.store.info', methods: ['GET'])]
    public function info(Store $store, StoreProcessor $processor): Response
    {
        return $this->json($processor->process($store));
    }
}

/*
 * @OA\Get(
 *     path="/market/stores",
 *     tags={"Market stores"},
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
 *                 @OA\Property(property="slug", type="string"),
 *                 @OA\Property(property="status", type="string"),
 *             )),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination"),
 *         )
 *     )
 * )
 */
