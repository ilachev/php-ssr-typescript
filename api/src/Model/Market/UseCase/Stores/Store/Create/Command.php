<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $author = null;
    /**
     * @Assert\NotBlank()
     */
    public ?string $name = null;
    /**
     * @Assert\Url()
     */
    public ?string $address = null;
    public ?array $categories = null;
    public ?string $description = null;
    public ?string $infoDetail = null;
    public ?string $infoContacts = null;
    public ?string $infoPayment = null;
    public ?string $infoDelivery = null;
    public ?int $sort = null;
    public ?string $metaTitle = null;
    public ?string $metaDescription = null;
    public ?string $metaOgTitle = null;
    public ?string $metaOgDescription = null;
    public ?string $seoHeading = null;
    public ?string $seoDescription = null;
    public ?Logo $logo = null;

    public function __construct(string $author)
    {
        $this->author = $author;
    }
}
