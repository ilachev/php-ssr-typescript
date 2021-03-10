<?php

declare(strict_types=1);

namespace App\Model\Market\Entity\Categories\Category\Logo;

use App\Model\Market\Entity\Categories\Category\Category;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="market_categories_category_logos", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class Logo
{
    /**
     * @ORM\Column(type="market_categories_category_logo_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Model\Market\Entity\Categories\Category\Category", inversedBy="logo")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private Category $category;
    /**
     * @ORM\Embedded(class="Info")
     */
    private Info $info;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    public function __construct(Id $id, Category $category, Info $info, DateTimeImmutable $date)
    {
        $this->id = $id;
        $this->category = $category;
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
