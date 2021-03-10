<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Store\Reinstate;

use App\Model\Flusher;
use App\Model\Market\Entity\Stores\Store\Id;
use App\Model\Market\Entity\Stores\Store\StoreRepository;

class Handler
{
    private StoreRepository $stores;
    private Flusher $flusher;

    public function __construct(StoreRepository $stores, Flusher $flusher)
    {
        $this->stores = $stores;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $store = $this->stores->get(new Id($command->id));

        $store->reinstate();

        $this->flusher->flush();
    }
}
