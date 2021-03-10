<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\ReadModel\Search\Filter;
use App\ReadModel\Search\SearchFetcher;
use App\Service\FrontendUrlBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class SearchController extends AbstractController
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private FrontendUrlBuilder $urlBuilder,
    ) {
    }

    #[Route('/search', name: 'search', methods: ['GET'])]
    public function home(Request $request, SearchFetcher $fetcher): Response
    {
        $filter = Filter::all();
        /** @var Filter $filter */
        $filter = $this->denormalizer->denormalize(
            $request->query->get('filter', []), Filter::class, 'array', [
            'object_to_populate' => $filter,
        ]);
        $result = $fetcher->all($filter);
        $output = [
            'stores' => [],
            'posts' => [],
        ];
        foreach ($result as $item) {
            $output[$item['type']][] = [
                'name' => $item['name'],
                'link' => $this->urlBuilder->generate(sprintf(
                    '%s/%s',
                    $item['category'],
                    $item['slug'],
                )),
            ];
        }

        return $this->json($output);
    }
}
