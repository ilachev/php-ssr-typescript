<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\SeoProcessable;

interface Processor
{
    public const SHORTCUTS = [
        '[[name]]',
        '[[day]]',
        '[[month]]',
        '[[year]]',
    ];

    public function process(SeoProcessable $entity): array;

    public function replaceShortcuts(SeoProcessable $entity, ?string $text): string;
}
