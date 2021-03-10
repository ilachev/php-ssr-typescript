<?php

declare(strict_types=1);

namespace App\Model\Market\UseCase\Promos\Setting\Edit;

use App\Model\Market\Entity\Promos\Setting\Setting;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $id = null;
    public ?string $templateSeoHeading = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromSetting(Setting $setting): self
    {
        $command = new self($setting->getId()->getValue());
        $command->templateSeoHeading = $setting->getTemplate()->getSeo()->getHeading();

        return $command;
    }
}
