<?php

declare(strict_types=1);

namespace App\Service;

interface UrlBuilder
{
    public function generate(string $path): string;
}
