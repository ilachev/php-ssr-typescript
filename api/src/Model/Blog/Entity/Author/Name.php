<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Author;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Name
{
    /**
     * @ORM\Column(type="string")
     */
    private ?string $first = null;
    /**
     * @ORM\Column(type="string")
     */
    private ?string $last = null;

    public function __construct(?string $first = null, ?string $last = null)
    {
        Assert::notEmpty($first);
        Assert::notEmpty($last);

        $this->first = $first;
        $this->last = $last;
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getLast(): string
    {
        return $this->last;
    }

    public function getFull(): string
    {
        return $this->first.' '.$this->last;
    }
}
