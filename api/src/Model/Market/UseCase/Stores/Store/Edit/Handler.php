<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Edit;

use App\Model\Flusher;
use App\Model\Market\Entity\Categories\Category\Category;
use App\Model\Market\Entity\Categories\Category\CategoryRepository;
use App\Model\Market\Entity\Categories\Category\Id as CategoryId;
use App\Model\Market\Entity\Stores\Store\Id;
use App\Model\Market\Entity\Stores\Store\Info;
use App\Model\Market\Entity\Stores\Store\Logo\Id as LogoId;
use App\Model\Market\Entity\Stores\Store\Logo\Info as LogoInfo;
use App\Model\Market\Entity\Stores\Store\Logo\Logo;
use App\Model\Market\Entity\Stores\Store\Meta;
use App\Model\Market\Entity\Stores\Store\Seo;
use App\Model\Market\Entity\Stores\Store\StoreRepository;
use DateTimeImmutable;

class Handler
{
    private StoreRepository $stores;
    private CategoryRepository $categories;
    private Flusher $flusher;

    public function __construct(StoreRepository $stores, CategoryRepository $categories, Flusher $flusher)
    {
        $this->stores = $stores;
        $this->categories = $categories;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $store = $this->stores->get(new Id($command->id));

        $store->edit(
            $command->name,
            $command->slug,
            new Seo(
                $command->seoHeading,
                $command->seoDescription,
            ),
            new Meta(
                $command->metaTitle,
                $command->metaDescription,
                $command->metaOgTitle,
                $command->metaOgDescription
            ),
            new Info(
                $command->infoDetail,
                $command->infoContacts,
                $command->infoPayment,
                $command->infoDelivery,
            ),
            $command->sort,
            $command->description,
            $command->address,
        );

        $logo = $command->logo;
        if ($logo) {
            if ($old = $store->getLogo()) {
                $store->removeLogo($old);

                $this->flusher->flush($store);
            }

            $store->setLogo(
                new Logo(
                    LogoId::next(),
                    $store,
                    new LogoInfo(
                        $logo->path,
                        $logo->name,
                        $logo->size
                    ),
                    new DateTimeImmutable()
                )
            );
        }

        /** @var Category $old */
        foreach ($store->getCategories() as $old) {
            $old->removeStore($store);
            $store->removeCategory($old);
        }

        $categories = $command->categories;
        if ($categories) {
            foreach ($categories as $id) {
                $category = $this->categories->get(new CategoryId($id));
                $category->addStore($store);
                $store->addCategory($category);
            }
        }

        $this->flusher->flush($store);
    }
}
