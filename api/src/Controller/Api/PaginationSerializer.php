<?php

declare(strict_types=1);

namespace App\Controller\Api;

use JetBrains\PhpStorm\ArrayShape;
use Knp\Component\Pager\Pagination\PaginationInterface;

class PaginationSerializer
{
    #[ArrayShape([
        'count' => 'int',
        'total' => 'int',
        'per_page' => 'int',
        'page' => 'int',
        'pages' => 'false|float',
    ])]
    public static function toArray(PaginationInterface $pagination): array
    {
        return [
            'count' => $pagination->count(),
            'total' => $pagination->getTotalItemCount(),
            'per_page' => $pagination->getItemNumberPerPage(),
            'page' => $pagination->getCurrentPageNumber(),
            'pages' => ceil($pagination->getTotalItemCount() / $pagination->getItemNumberPerPage()),
        ];
    }
}
