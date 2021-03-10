<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Stores\Store;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Info
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $detail = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $contacts = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $payment = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $delivery = null;

    public function __construct(
        ?string $detail = null,
        ?string $contacts = null,
        ?string $payment = null,
        ?string $delivery = null
    ) {
        $this->detail = $detail;
        $this->contacts = $contacts;
        $this->payment = $payment;
        $this->delivery = $delivery;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }
}
