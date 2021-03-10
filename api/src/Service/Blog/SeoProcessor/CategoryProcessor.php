<?php

declare(strict_types=1);

namespace App\Service\Blog\SeoProcessor;

use App\Model\Blog\Entity\Categories\Category\Category;
use App\Model\Blog\Entity\Categories\Setting\Setting;
use App\Model\SeoProcessable;
use App\ReadModel\Blog\Categories\Setting\SettingFetcher;
use App\Service\Processor;
use DateTimeImmutable;
use IntlDateFormatter;
use JetBrains\PhpStorm\ArrayShape;

class CategoryProcessor implements Processor
{
    public function __construct(
        private SettingFetcher $settings,
    ) {
    }

    /**
     * @param Category $category
     *
     * @return array
     */
    #[ArrayShape(['seo' => 'array'])]
    public function process(SeoProcessable $category): array
    {
        $setting = $this->settings->find(Setting::PRIMARY);

        $seoHeading = $category->getSeo()->getHeading();
        if ((null === $seoHeading) && null !== $setting) {
            $seoHeading = $setting->getTemplate()->getSeo()->getHeading();
        }
        $seoDescription = $category->getSeo()->getDescription();
        if ((null === $seoDescription) && null !== $setting) {
            $seoDescription = $setting->getTemplate()->getSeo()->getDescription();
        }
        $metaTitle = $category->getMeta()->getTitle();
        if ((null === $metaTitle) && null !== $setting) {
            $metaTitle = $setting->getTemplate()->getMeta()->getTitle();
        }
        $metaDescription = $category->getMeta()->getDescription();
        if ((null === $metaDescription) && null !== $setting) {
            $metaDescription = $setting->getTemplate()->getMeta()->getDescription();
        }
        $metaOgTitle = $category->getMeta()->getOgTitle();
        if ((null === $metaOgTitle) && null !== $setting) {
            $metaOgTitle = $setting->getTemplate()->getMeta()->getOgTitle();
        }
        $metaOgDescription = $category->getMeta()->getOgDescription();
        if ((null === $metaOgDescription) && null !== $setting) {
            $metaOgDescription = $setting->getTemplate()->getMeta()->getOgDescription();
        }

        $seoHeading = $seoHeading ?? $category->getName();
        $seoDescription = $seoDescription ?? $category->getDescription();
        $metaTitle = $metaTitle ?? $category->getName();
        $metaDescription = $metaDescription ?? $category->getDescription();
        $metaOgTitle = $metaOgTitle ?? $category->getName();
        $metaOgDescription = $metaOgDescription ?? $category->getDescription();

        return [
            'seo' => [
                'h1' => $this->replaceShortcuts($category, $seoHeading),
                'description' => $this->replaceShortcuts($category, $seoDescription),
                'meta' => [
                    'title' => $this->replaceShortcuts($category, $metaTitle),
                    'description' => $this->replaceShortcuts($category, $metaDescription),
                    'og_title' => $this->replaceShortcuts($category, $metaOgTitle),
                    'og_description' => $this->replaceShortcuts($category, $metaOgDescription),
                ],
            ],
        ];
    }

    /**
     * @param Category $store
     */
    public function replaceShortcuts(SeoProcessable $category, ?string $text = null): string
    {
        if (null === $text) {
            return '';
        }

        return str_replace(
            [...Processor::SHORTCUTS],
            [
                $category->getName(),
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
