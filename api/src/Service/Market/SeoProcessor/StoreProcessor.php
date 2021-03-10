<?php

declare(strict_types=1);

namespace App\Service\Market\SeoProcessor;

use App\Model\Market\Entity\Stores\Setting\Setting;
use App\Model\Market\Entity\Stores\Store\Store;
use App\Model\SeoProcessable;
use App\ReadModel\Market\Stores\Setting\SettingFetcher;
use App\Service\Processor;
use DateTimeImmutable;
use IntlDateFormatter;
use JetBrains\PhpStorm\ArrayShape;

class StoreProcessor implements Processor
{
    private SettingFetcher $settings;

    public function __construct(SettingFetcher $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param Store $store
     *
     * @return array
     */
    #[ArrayShape(['seo' => 'array'])]
    public function process(SeoProcessable $store): array
    {
        $setting = $this->settings->find(Setting::PRIMARY);

        $seoHeading = $store->getSeo()->getHeading();
        if ((null === $seoHeading) && null !== $setting) {
            $seoHeading = $setting->getTemplate()->getSeo()->getHeading();
        }
        $seoDescription = $store->getSeo()->getDescription();
        if ((null === $seoDescription) && null !== $setting) {
            $seoDescription = $setting->getTemplate()->getSeo()->getDescription();
        }
        $metaTitle = $store->getMeta()->getTitle();
        if ((null === $metaTitle) && null !== $setting) {
            $metaTitle = $setting->getTemplate()->getMeta()->getTitle();
        }
        $metaDescription = $store->getMeta()->getDescription();
        if ((null === $metaDescription) && null !== $setting) {
            $metaDescription = $setting->getTemplate()->getMeta()->getDescription();
        }
        $metaOgTitle = $store->getMeta()->getOgTitle();
        if ((null === $metaOgTitle) && null !== $setting) {
            $metaOgTitle = $setting->getTemplate()->getMeta()->getOgTitle();
        }
        $metaOgDescription = $store->getMeta()->getOgDescription();
        if ((null === $metaOgDescription) && null !== $setting) {
            $metaOgDescription = $setting->getTemplate()->getMeta()->getOgDescription();
        }

        $seoHeading = $seoHeading ?? $store->getName();
        $seoDescription = $seoDescription ?? $store->getDescription();
        $metaTitle = $metaTitle ?? $store->getName();
        $metaDescription = $metaDescription ?? $store->getDescription();
        $metaOgTitle = $metaOgTitle ?? $store->getName();
        $metaOgDescription = $metaOgDescription ?? $store->getDescription();

        return [
            'seo' => [
                'h1' => $this->replaceShortcuts($store, $seoHeading),
                'description' => $this->replaceShortcuts($store, $seoDescription),
                'meta' => [
                    'title' => $this->replaceShortcuts($store, $metaTitle),
                    'description' => $this->replaceShortcuts($store, $metaDescription),
                    'og_title' => $this->replaceShortcuts($store, $metaOgTitle),
                    'og_description' => $this->replaceShortcuts($store, $metaOgDescription),
                ],
            ],
        ];
    }

    /**
     * @param Store $store
     */
    public function replaceShortcuts(SeoProcessable $store, ?string $text = null): string
    {
        if (null === $text) {
            return '';
        }

        return str_replace(
            [...Processor::SHORTCUTS],
            [
                $store->getName(),
                (new DateTimeImmutable())->format('d'),
                (new IntlDateFormatter(
                    'ru_Ru',
                    IntlDateFormatter::NONE,
                    IntlDateFormatter::NONE,
                    null,
                    null,
                    'LLLL'
                ))->format(new DateTimeImmutable()),
                (new DateTimeImmutable())->format('Y'),
            ],
            $text
        );
    }
}
