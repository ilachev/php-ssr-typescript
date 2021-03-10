<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Create;

use App\Model\Flusher;
use App\Model\Market\Entity\Author\AuthorRepository;
use App\Model\Market\Entity\Author\Id as AuthorId;
use App\Model\Market\Entity\Categories\Category\CategoryRepository;
use App\Model\Market\Entity\Categories\Category\Id as CategoryId;
use App\Model\Market\Entity\Stores\Store\Id;
use App\Model\Market\Entity\Stores\Store\Info;
use App\Model\Market\Entity\Stores\Store\Logo\Id as LogoId;
use App\Model\Market\Entity\Stores\Store\Logo\Info as LogoInfo;
use App\Model\Market\Entity\Stores\Store\Logo\Logo;
use App\Model\Market\Entity\Stores\Store\Meta;
use App\Model\Market\Entity\Stores\Store\Seo;
use App\Model\Market\Entity\Stores\Store\Store;
use App\Model\Market\Entity\Stores\Store\StoreRepository;
use DateTimeImmutable;
use Symfony\Component\String\Slugger\SluggerInterface;

class Handler
{
    private SluggerInterface $slugger;
    private StoreRepository $stores;
    private AuthorRepository $authors;
    private CategoryRepository $categories;
    private Flusher $flusher;

    public function __construct(
        SluggerInterface $slugger,
        StoreRepository $stores,
        AuthorRepository $authors,
        CategoryRepository $categories,
        Flusher $flusher
    ) {
        $this->slugger = $slugger;
        $this->stores = $stores;
        $this->authors = $authors;
        $this->categories = $categories;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $author = $this->authors->get(new AuthorId($command->author));

        $store = new Store(
            Id::next(),
            $author,
            $command->name,
            new DateTimeImmutable(),
            $this->slugger->slug($command->name)->lower()->toString(),
            new Seo(
                $command->seoHeading,
                $command->seoDescription
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

        $categories = $command->categories;
        if ($categories) {
            foreach ($categories as $id) {
                $category = $this->categories->get(new CategoryId($id));
                $category->addStore($store);
                $store->addCategory($category);
            }
        }

        $this->stores->add($store);
        $this->flusher->flush();
    }
}
