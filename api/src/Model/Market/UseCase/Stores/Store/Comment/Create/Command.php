<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Comment\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[Assert\NotBlank(message: 'Комментарий не может быть пустым.')]
    public string $text = '';

    #[Assert\NotBlank]
    public string $token = '';

    #[Assert\Uuid(versions: [Assert\Uuid::V4_RANDOM])]
    public string $storeId = '';

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Uuid(versions: [Assert\Uuid::V4_RANDOM])]
    public ?string $parentId = null;
}
