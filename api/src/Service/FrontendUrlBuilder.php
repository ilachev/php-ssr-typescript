<?php

declare(strict_types=1);

namespace App\Service;

class FrontendUrlBuilder implements UrlBuilder
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function generate(string $path): string
    {
        return $this->baseUrl.'/'.$path;
    }
}
