<?php

declare(strict_types=1);

namespace App\Menu\Market\Promos;

use App\Model\Market\Entity\Promos\Setting\Setting;
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

        if ($this->auth->isGranted('ROLE_MARKET_MANAGE_PROMOS')) {
            $menu
                ->addChild('Промо', [
                    'route' => 'market.promos',
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');

            $menu
                ->addChild('Шаблоны', [
                    'route' => 'market.promos.setting.show',
                    'routeParameters' => ['id' => Setting::PRIMARY],
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        return $menu;
    }
}
