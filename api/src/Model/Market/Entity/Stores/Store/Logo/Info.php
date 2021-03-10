<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Stores\Store\Logo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Info
{
    /**
     * @ORM\Column(type="string")
     */
    private string $path;
    /**
     * @ORM\Column(type="string")
     */
    private string $name;
    /**
     * @ORM\Column(type="integer")
     */
    private int $size;

    public function __construct(string $path, string $name, int $size)
    {
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
