<?php

declare(strict_types=1);

namespace App\Menu\Market\Stores;

use App\Model\Market\Entity\Stores\Setting\Setting;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MainMenu
{
    public function __construct(
        private FactoryInterface $factory,
        private AuthorizationCheckerInterface $auth,
    ) {
    }

    public function build(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttributes(['class' => 'nav nav-tabs mb-4']);

        if ($this->auth->isGranted('ROLE_MARKET_MANAGE_STORES')) {
            $menu
                ->addChild('Магазины', [
                    'route' => 'market.stores',
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Комментарии', [
                    'route' => 'market.stores.comments',
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Шаблоны', [
                    'route' => 'market.stores.setting.show',
                    'routeParameters' => ['id' => Setting::PRIMARY],
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        return $menu;
    }
}
