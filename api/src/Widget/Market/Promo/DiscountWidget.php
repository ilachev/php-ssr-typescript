<?php

declare(strict_types=1);

namespace App\Widget\Market\Promo;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DiscountWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('market_promo_discount', [$this, 'discount'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function discount(Environment $twig, int $discount, string $discountUnit): string
    {
        return $twig->render('widget/market/promo/discount.html.twig', [
            'discount' => $discount,
            'discountUnit' => $discountUnit,
        ]);
    }
}
