<?php

declare(strict_types=1);

namespace App\Widget\Market\Promo;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TypeWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('market_promo_type', [$this, 'type'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function type(Environment $twig, string $type): string
    {
        return $twig->render('widget/market/promo/type.html.twig', [
            'type' => $type,
        ]);
    }
}
