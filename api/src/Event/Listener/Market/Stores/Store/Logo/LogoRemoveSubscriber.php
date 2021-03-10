<?php

declare(strict_types=1);

namespace App\Event\Listener\Market\Stores\Store\Logo;

use App\Model\Market\Entity\Stores\Store\Event\StoreLogoRemoved;
use App\Service\Uploader\FileUploader;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LogoRemoveSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private FileUploader $uploader,
    ) {
    }

    #[ArrayShape([StoreLogoRemoved::class => 'string'])]
    public static function getSubscribedEvents(): array
    {
        return [
            StoreLogoRemoved::class => 'onStoreLogoRemoved',
        ];
    }

    public function onStoreLogoRemoved(StoreLogoRemoved $event): void
    {
        $this->uploader->remove($event->info->getPath(), $event->info->getName());
    }
}
