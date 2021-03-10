<?php

namespace App\Controller\Api\Blog\Categories;

use App\Model\Blog\Entity\Categories\Category\Category;
use App\Service\Blog\SeoProcessor\CategoryProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    #[Route('/blog/categories/{slug}', name: 'blog.categories.category.show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->json([
            'id' => $category->getId()->getValue(),
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
        ]);
    }

    #[Route('/blog/categories/{slug}/info', name: 'blog.categories.category.info', methods: ['GET'])]
    public function info(Category $store, CategoryProcessor $processor): Response
    {
        return $this->json($processor->process($store));
    }
}
