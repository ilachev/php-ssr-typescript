<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Stores\Store\Logo;

use App\Model\Market\Entity\Stores\Store\Store;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="market_stores_store_logos", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class Logo
{
    /**
     * @ORM\Column(type="market_stores_store_logo_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Model\Market\Entity\Stores\Store\Store", inversedBy="logo")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", nullable=false)
     */
    private Store $store;
    /**
     * @ORM\Embedded(class="Info")
     */
    private Info $info;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    public function __construct(Id $id, Store $store, Info $info, DateTimeImmutable $date)
    {
        $this->store = $store;
        $this->id = $id;
        $this->date = $date;
        $this->info = $info;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }
}
