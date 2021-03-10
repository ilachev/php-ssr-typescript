<?php

declare(strict_types=1);

namespace App\Service;

use JetBrains\PhpStorm\Pure;

class PluralWordForm
{
    #[Pure]
    public static function format(
        int $number,
        array $items = [],
        bool $returnNumber = true
    ): string {
        $cases = [2, 0, 1, 1, 1, 2];

        return ($returnNumber ? $number.' ' : '').
            $items[($number % 100 > 4 && $number % 100 < 20) ?
                2 :
                $cases[min($number % 10, 5)]]
        ;
    }
}
