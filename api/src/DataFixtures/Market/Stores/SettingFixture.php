<?php

declare(strict_types=1);

namespace App\DataFixtures\Market\Stores;

use App\Model\Market\Entity\Stores\Setting\Id;
use App\Model\Market\Entity\Stores\Setting\Setting;
use App\Model\Market\Entity\Stores\Setting\Template\Meta;
use App\Model\Market\Entity\Stores\Setting\Template\Seo;
use App\Model\Market\Entity\Stores\Setting\Template\Template;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SettingFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $setting = $this->createSetting(Setting::PRIMARY);
        $manager->persist($setting);
        $manager->flush();
    }

    private function createSetting(string $settingType): Setting
    {
        return new Setting(
            new Id($settingType),
            new Template(
                new Seo(
                    'Промокоды [[name]] [[month]] [[year]]',
                    'Подборка активных промокодов и купонов для [[name]], которые вы можете применить в [[month]] [[year]] года.'
                ),
                new Meta(
                    'Промокоды [[name]] [[month]] [[year]]',
                    'Подборка активных промокодов и купонов для [[name]], которые вы можете применить в [[month]] [[year]] года.',
                    'Промокоды [[name]] [[month]] [[year]]',
                    'Подборка активных промокодов и купонов для [[name]], которые вы можете применить в [[month]] [[year]] года.'
                )
            )
        );
    }
}
