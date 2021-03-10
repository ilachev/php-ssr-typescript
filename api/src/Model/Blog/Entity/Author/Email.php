<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Author;

use JetBrains\PhpStorm\Pure;
use Webmozart\Assert\Assert;

class Email
{
    public function __construct(
        private ?string $value = null,
    ) {
        Assert::notEmpty($value);
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Incorrect email.');
        }
        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    #[Pure]
    public function isEqual(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }
}
