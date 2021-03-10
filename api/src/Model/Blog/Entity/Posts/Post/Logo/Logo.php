<?php

declare(strict_types=1);

namespace App\Model\Blog\Entity\Posts\Post\Logo;

use App\Model\Blog\Entity\Posts\Post\Post;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="blog_posts_post_logos", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class Logo
{
    /**
     * @ORM\Column(type="blog_posts_post_logo_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\OneToOne(targetEntity="App\Model\Blog\Entity\Posts\Post\Post", inversedBy="logo")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     */
    private Post $post;
    /**
     * @ORM\Embedded(class="Info")
     */
    private Info $info;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    public function __construct(Id $id, Post $post, Info $info, DateTimeImmutable $date)
    {
        $this->post = $post;
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
