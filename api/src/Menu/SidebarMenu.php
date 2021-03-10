<?php

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SidebarMenu
{
    public function __construct(
        private FactoryInterface $factory,
        private AuthorizationCheckerInterface $auth,
    ) {
    }

    public function build(): ItemInterface
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttributes(['class' => 'nav']);

        $menu->addChild('Главная', ['route' => 'home'])
            ->setExtra('icon', 'nav-icon icon-speedometer')
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Витрина')->setAttribute('class', 'nav-title');

        if ($this->auth->isGranted('ROLE_MARKET_MANAGE_STORES')) {
            $menu->addChild('Магазины', ['route' => 'market.stores'])
                ->setChildrenAttributes(['class' => 'nav'])
                ->setExtra('routes', [
                    ['route' => 'market.stores'],
                    ['pattern' => '/^market.stores\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-briefcase')
                ->setAttribute('class', 'nav-item dropdown')
                ->setLinkAttribute('class', 'nav-link')
            ;
            $menu
                ->getChild('Магазины')
                ?->addChild('Комментарии', ['route' => 'market.stores.comments'])
                ->setExtra('routes', [
                    ['route' => 'market.stores.comments'],
                    ['pattern' => '/^market.stores.comments\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-briefcase')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link pl-4')
            ;
        }

        if ($this->auth->isGranted('ROLE_MARKET_MANAGE_PROMOS')) {
            $menu->addChild('Промо', ['route' => 'market.promos'])
                ->setExtra('routes', [
                    ['route' => 'market.promos'],
                    ['pattern' => '/^market.promos\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-bag')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        if ($this->auth->isGranted('ROLE_MARKET_MANAGE_CATEGORIES')) {
            $menu->addChild('Категории', ['route' => 'market.categories'])
                ->setExtra('routes', [
                    ['route' => 'market.categories'],
                    ['pattern' => '/^market.categories\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-folder')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        if ($this->auth->isGranted('ROLE_MARKET_MANAGE_AUTHORS')) {
            $menu->addChild('Авторы витрины', ['route' => 'market.authors'])
                ->setExtra('routes', [
                    ['route' => 'market.authors'],
                    ['pattern' => '/^market\.authors\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-people')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        $menu->addChild('Блог')->setAttribute('class', 'nav-title');

        if ($this->auth->isGranted('ROLE_BLOG_MANAGE_POSTS')) {
            $menu->addChild('Статьи', ['route' => 'blog.posts'])
                ->setChildrenAttributes(['class' => 'nav'])
                ->setExtra('routes', [
                    ['route' => 'blog.posts'],
                    ['pattern' => '/^blog.posts\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-briefcase')
                ->setAttribute('class', 'nav-item dropdown')
                ->setLinkAttribute('class', 'nav-link');
            $menu
                ->getChild('Статьи')
                ?->addChild('Комментарии статей', ['route' => 'blog.posts.comments'])
                ->setExtra('routes', [
                    ['route' => 'blog.posts.comments'],
                    ['pattern' => '/^blog.posts.comments\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-briefcase')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link pl-4')
            ;
        }

        if ($this->auth->isGranted('ROLE_BLOG_MANAGE_CATEGORIES')) {
            $menu->addChild('Категории статей', ['route' => 'blog.categories'])
                ->setExtra('routes', [
                    ['route' => 'blog.categories'],
                    ['pattern' => '/^blog.categories\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-folder')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        if ($this->auth->isGranted('ROLE_BLOG_MANAGE_AUTHORS')) {
            $menu->addChild('Авторы блога', ['route' => 'blog.authors'])
                ->setExtra('routes', [
                    ['route' => 'blog.authors'],
                    ['pattern' => '/^blog\.authors\..+/'],
                ])
                ->setExtra('icon', 'nav-icon icon-people')
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        $menu->addChild('Управление')->setAttribute('class', 'nav-title');

        if ($this->auth->isGranted('ROLE_MANAGE_USERS')) {
            $menu->addChild('Пользователи', ['route' => 'users'])
                ->setExtra('icon', 'nav-icon icon-people')
                ->setExtra('routes', [
                    ['route' => 'users'],
                    ['pattern' => '/^users\..+/'],
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        $menu->addChild('Профиль', ['route' => 'profile'])
            ->setExtra('icon', 'nav-icon icon-user')
            ->setExtra('routes', [
                ['route' => 'profile'],
                ['pattern' => '/^profile\..+/'],
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        return $menu;
    }
}
