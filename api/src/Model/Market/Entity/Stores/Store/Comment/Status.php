<?php

namespace App\Model\Market\Entity\Stores\Store\Comment;

use JetBrains\PhpStorm\Pure;
use Webmozart\Assert\Assert;

class Status
{
    public const DRAFT = 'draft';
    public const APPROVED = 'approved';
    public const DECLINED = 'declined';

    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::DRAFT,
            self::APPROVED,
            self::DECLINED,
        ]);

        $this->name = $name;
    }

    public static function draft(): self
    {
        return new self(self::DRAFT);
    }

    public static function approved(): self
    {
        return new self(self::APPROVED);
    }

    public static function declined(): self
    {
        return new self(self::DECLINED);
    }

    #[Pure]
    public function isEqual(self $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isDraft(): bool
    {
        return self::DRAFT === $this->name;
    }

    public function isApproved(): bool
    {
        return self::APPROVED === $this->name;
    }

    public function isDeclined(): bool
    {
        return self::DECLINED === $this->name;
    }
}
