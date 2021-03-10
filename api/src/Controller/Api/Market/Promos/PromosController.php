<?php

declare(strict_types=1);

namespace App\Controller\Api\Market\Promos;

use App\Controller\Api\PaginationSerializer;
use App\Model\Market\Entity\Promos\Promo\Type;
use App\ReadModel\Market\Promos\Promo\Filter;
use App\ReadModel\Market\Promos\Promo\PromoFetcher;
use App\ReadModel\Market\Promos\Promo\ReferralLink\Filter\Filter as ReferralLinkFilter;
use App\ReadModel\Market\Promos\Promo\ReferralLink\ReferralLinkFetcher;
use App\Service\FrontendUrlBuilder;
use DateTimeImmutable;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Uid\Ulid;

class PromosController extends AbstractController
{
    private const PER_PAGE = 50;

    public function __construct(
        private DenormalizerInterface $denormalizer,
        private FrontendUrlBuilder $urlBuilder,
    ) {
    }

    #[Route('/market/promos', name: 'market.promos', methods: ['GET'])]
    public function index(Request $request, PromoFetcher $fetcher): Response
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
                    'type' => $item['type'],
                    'status' => $item['status'],
                    'discount' => $item['discount'],
                    'discount_unit' => $item['discount_unit'],
                    'description' => $item['description'],
                    'start_date' => (new \IntlDateFormatter(
                        'ru_Ru',
                        \IntlDateFormatter::NONE,
                        \IntlDateFormatter::NONE,
                        null,
                        null,
                        'd MMMM y'
                    ))->format(new DateTimeImmutable($item['start_date'])),
                    'end_date' => (new \IntlDateFormatter(
                        'ru_Ru',
                        \IntlDateFormatter::NONE,
                        \IntlDateFormatter::NONE,
                        null,
                        null,
                        'd MMMM y'
                    ))->format(new DateTimeImmutable($item['end_date'])),
                    'is_expired' => new DateTimeImmutable($item['end_date']) < new DateTimeImmutable(),
                    'code' => $item['code'],
                    'referral' => $this->urlBuilder->generate(
                        sprintf(
                            'go/%s',
                            Ulid::fromString($item['referral'])->toBase58(),
                        ),
                    ),
                ];
            }, (array) $pagination->getItems()),
            'pagination' => PaginationSerializer::toArray($pagination),
        ]);
    }

    #[Route('/market/promos/count', name: 'market.promos.count', methods: ['GET'])]
    public function count(Request $request, PromoFetcher $fetcher): Response
    {
        $filter = Filter\Filter::all();

        /** @var Filter\Filter $filter */
        $filter = $this->denormalizer->denormalize(
            $request->query->get('filter', []), Filter\Filter::class, 'json', [
            'object_to_populate' => $filter,
            'ignored_attributes' => ['author'],
        ]);

        $count = $fetcher->allCount($filter);

        return $this->json([
            'count' => array_merge(
                [[
                    'type' => 'all',
                    'count' => array_sum(array_map(static fn (array $elem) => $elem['count'], $count)),
                    'name' => 'Все',
                ]],
                array_map(static function (array $item) {
                    return [
                        'type' => $item['type'],
                        'count' => $item['count'],
                        'name' => (new Type($item['type']))->getValue(),
                    ];
                }, $count)),
        ]);
    }

    #[Route('/market/promos/referral', name: 'market.promos.referral', methods: ['GET'])]
    public function referral(Request $request, ReferralLinkFetcher $fetcher): Response
    {
        $filter = ReferralLinkFilter::all();

        /** @var ReferralLinkFilter $filter */
        $filter = $this->denormalizer->denormalize(
            $request->query->get('filter', []), ReferralLinkFilter::class, 'json', [
            'object_to_populate' => $filter,
        ]);

        if (!$referralLink = $fetcher->findByInternalId(Ulid::fromString($filter->ulid))) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'link' => $referralLink->getLink(),
        ]);
    }
}

/*
 * @OA\Get(
 *     path="/market/promos",
 *     tags={"Market promos"},
 *     @OA\Parameter(
 *         name="filter[name]",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         style="form"
 *     ),
 *     @OA\Parameter(
 *         name="filter[type]",
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
 *                 @OA\Property(property="type", type="string"),
 *                 @OA\Property(property="status", type="string"),
 *             )),
 *             @OA\Property(property="pagination", ref="#/components/schemas/Pagination"),
 *         )
 *     )
 * )
 */
