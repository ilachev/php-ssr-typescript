<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Post\Comment\Approve;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[Assert\NotBlank]
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
