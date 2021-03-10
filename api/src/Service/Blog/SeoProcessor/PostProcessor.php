<?php

declare(strict_types=1);

namespace App\Service\Blog\SeoProcessor;

use App\Model\Blog\Entity\Posts\Post\Post;
use App\Model\Blog\Entity\Posts\Setting\Setting;
use App\Model\SeoProcessable;
use App\ReadModel\Blog\Posts\Setting\SettingFetcher;
use App\Service\Blog\PreviewDescriptionFormatter;
use App\Service\Processor;
use DateTimeImmutable;
use IntlDateFormatter;
use JetBrains\PhpStorm\ArrayShape;

class PostProcessor implements Processor
{
    public function __construct(
        private SettingFetcher $settings,
    ) {
    }

    /**
     * @param Post $post
     *
     * @return array
     */
    #[ArrayShape(['seo' => 'array'])]
    public function process(SeoProcessable $post): array
    {
        $setting = $this->settings->find(Setting::PRIMARY);

        $seoHeading = $post->getSeo()->getHeading();
        if ((null === $seoHeading) && null !== $setting) {
            $seoHeading = $setting->getTemplate()->getSeo()->getHeading();
        }
        $seoDescription = $post->getSeo()->getDescription();
        if ((null === $seoDescription) && null !== $setting) {
            $seoDescription = $setting->getTemplate()->getSeo()->getDescription();
        }
        $metaTitle = $post->getMeta()->getTitle();
        if ((null === $metaTitle) && null !== $setting) {
            $metaTitle = $setting->getTemplate()->getMeta()->getTitle();
        }
        $metaDescription = $post->getMeta()->getDescription();
        if ((null === $metaDescription) && null !== $setting) {
            $metaDescription = $setting->getTemplate()->getMeta()->getDescription();
        }
        $metaOgTitle = $post->getMeta()->getOgTitle();
        if ((null === $metaOgTitle) && null !== $setting) {
            $metaOgTitle = $setting->getTemplate()->getMeta()->getOgTitle();
        }
        $metaOgDescription = $post->getMeta()->getOgDescription();
        if ((null === $metaOgDescription) && null !== $setting) {
            $metaOgDescription = $setting->getTemplate()->getMeta()->getOgDescription();
        }

        $seoHeading = $seoHeading ?? $post->getName();
        $seoDescription = $seoDescription ?? PreviewDescriptionFormatter::format($post->getDescription());
        $metaTitle = $metaTitle ?? $post->getName();
        $metaDescription = $metaDescription ?? PreviewDescriptionFormatter::format($post->getDescription());
        $metaOgTitle = $metaOgTitle ?? $post->getName();
        $metaOgDescription = $metaOgDescription ?? PreviewDescriptionFormatter::format($post->getDescription());

        return [
            'seo' => [
                'h1' => $this->replaceShortcuts($post, $seoHeading),
                'description' => $this->replaceShortcuts($post, $seoDescription),
                'meta' => [
                    'title' => $this->replaceShortcuts($post, $metaTitle),
                    'description' => $this->replaceShortcuts($post, $metaDescription),
                    'og_title' => $this->replaceShortcuts($post, $metaOgTitle),
                    'og_description' => $this->replaceShortcuts($post, $metaOgDescription),
                ],
            ],
        ];
    }

    /**
     * @param Post $post
     */
    public function replaceShortcuts(SeoProcessable $post, ?string $text = null): string
    {
        if (null === $text) {
            return '';
        }

        return str_replace(
            [...Processor::SHORTCUTS],
            [
                $post->getName(),
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
