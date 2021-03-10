<?php

declare(strict_types=1);

namespace App\Event\Listener\Market\Categories\Category\Logo;

use App\Model\Market\Entity\Categories\Category\Event\CategoryLogoRemoved;
use App\Service\Uploader\FileUploader;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogoRemoveSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private FileUploader $uploader,
    ) {
    }

    #[ArrayShape([CategoryLogoRemoved::class => 'string'])]
    public static function getSubscribedEvents(): array
    {
        return [
            CategoryLogoRemoved::class => 'onCategoryLogoRemoved',
        ];
    }

    public function onCategoryLogoRemoved(CategoryLogoRemoved $event): void
    {
        $this->uploader->remove($event->info->getPath(), $event->info->getName());
    }
}
