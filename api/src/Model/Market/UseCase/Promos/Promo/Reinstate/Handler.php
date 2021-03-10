<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Promos\Promo\Reinstate;

use App\Model\Flusher;
use App\Model\Market\Entity\Promos\Promo\Id;
use App\Model\Market\Entity\Promos\Promo\PromoRepository;

class Handler
{
    private PromoRepository $promos;
    private Flusher $flusher;

    public function __construct(PromoRepository $promos, Flusher $flusher)
    {
        $this->promos = $promos;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $promo = $this->promos->get(new Id($command->id));

        $promo->reinstate();

        $this->flusher->flush();
    }
}
