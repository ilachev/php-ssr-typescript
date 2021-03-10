<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Edit;

use App\Model\Market\Entity\Categories\Category\Category;
use App\Model\Market\Entity\Stores\Store\Store;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $id = null;
    /**
     * @Assert\NotBlank()
     */
    public ?string $name = null;
    public ?array $categories = null;
    /**
     * @Assert\Url()
     */
    public ?string $address = null;
    public ?string $description = null;
    /**
     * @Assert\NotBlank()
     */
    public string $slug;
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

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromStore(Store $store): self
    {
        $command = new self($store->getId()->getValue());
        $command->name = $store->getName();
        $command->address = $store->getAddress();
        $command->description = $store->getDescription();
        $command->categories = array_map(
            fn (Category $category) => $category->getId()->getValue(),
            $store->getCategories()->toArray()
        );
        $command->slug = $store->getSlug();
        $command->sort = $store->getSort();
        $command->metaTitle = $store->getMeta()->getTitle();
        $command->metaDescription = $store->getMeta()->getDescription();
        $command->metaOgTitle = $store->getMeta()->getOgTitle();
        $command->metaOgDescription = $store->getMeta()->getOgDescription();
        $command->seoHeading = $store->getSeo()->getHeading();
        $command->seoDescription = $store->getSeo()->getHeading();
        $command->infoDetail = $store->getInfo()->getDetail();
        $command->infoContacts = $store->getInfo()->getContacts();
        $command->infoPayment = $store->getInfo()->getPayment();
        $command->infoDelivery = $store->getInfo()->getDelivery();

        return $command;
    }
}
