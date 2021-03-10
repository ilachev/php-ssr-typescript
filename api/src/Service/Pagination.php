<?php

declare(strict_types=1);

namespace App\Service;

use Knp\Component\Pager\Pagination\PaginationInterface;

class Pagination
{
    public static function isNotLastPage(PaginationInterface $pagination): bool
    {
        return $pagination->getCurrentPageNumber() <
            ceil($pagination->getTotalItemCount() / $pagination->getItemNumberPerPage());
    }
}
