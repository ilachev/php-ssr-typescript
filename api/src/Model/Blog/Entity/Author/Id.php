<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Author;

use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;

class Id
{
    public function __construct(
        private ?string $value = null,
    ) {
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    #[Pure]
    public function isEqual(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
