<?php

declare(strict_types=1);

namespace App\Controller;

use DomainException;
use Psr\Log\LoggerInterface;

class ErrorHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function handle(DomainException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
