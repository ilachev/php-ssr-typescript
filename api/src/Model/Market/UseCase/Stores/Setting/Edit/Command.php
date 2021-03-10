<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Stores\Setting\Edit;

use App\Model\Market\Entity\Stores\Setting\Setting;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $id = null;
    public ?string $templateMetaTitle = null;
    public ?string $templateMetaDescription = null;
    public ?string $templateMetaOgTitle = null;
    public ?string $templateMetaOgDescription = null;
    public ?string $templateSeoHeading = null;
    public ?string $templateSeoDescription = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromSetting(Setting $setting): self
    {
        $command = new self($setting->getId()->getValue());
        $command->templateMetaTitle = $setting->getTemplate()->getMeta()->getTitle();
        $command->templateMetaDescription = $setting->getTemplate()->getMeta()->getDescription();
        $command->templateMetaOgTitle = $setting->getTemplate()->getMeta()->getOgTitle();
        $command->templateMetaOgDescription = $setting->getTemplate()->getMeta()->getOgDescription();
        $command->templateSeoHeading = $setting->getTemplate()->getSeo()->getHeading();
        $command->templateSeoDescription = $setting->getTemplate()->getSeo()->getDescription();

        return $command;
    }
}
