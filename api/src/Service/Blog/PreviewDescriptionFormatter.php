<?php

declare(strict_types=1);

namespace App\Service\Blog;

use Symfony\Component\String\UnicodeString;

class PreviewDescriptionFormatter
{
    public static function format(string $description): string
    {
        $string = new UnicodeString(html_entity_decode(strip_tags($description)));

        return $string
            ->normalize()
            ->truncate(150, '...')
            ->toString()
        ;
    }
}
