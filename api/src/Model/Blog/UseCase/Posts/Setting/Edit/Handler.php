<?php

declare(strict_types=1);

namespace App\Model\Blog\UseCase\Posts\Setting\Edit;

use App\Model\Blog\Entity\Posts\Setting\Id;
use App\Model\Blog\Entity\Posts\Setting\SettingRepository;
use App\Model\Blog\Entity\Posts\Setting\Template\Meta;
use App\Model\Blog\Entity\Posts\Setting\Template\Seo;
use App\Model\Blog\Entity\Posts\Setting\Template\Template;
use App\Model\Flusher;

class Handler
{
    private SettingRepository $settings;
    private Flusher $flusher;

    public function __construct(SettingRepository $settings, Flusher $flusher)
    {
        $this->settings = $settings;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $setting = $this->settings->get(new Id($command->id));

        $setting->edit(new Template(
            new Seo(
                $command->templateSeoHeading,
                $command->templateSeoDescription
            ),
            new Meta(
                $command->templateMetaTitle,
                $command->templateMetaDescription,
                $command->templateMetaOgTitle,
                $command->templateMetaOgDescription
            )
        ));

        $this->flusher->flush();
    }
}
