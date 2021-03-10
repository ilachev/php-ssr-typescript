<?php

declare(strict_types=1);

namespace App\DataFixtures\Market\Categories;

use App\Model\Market\Entity\Categories\Setting\Id;
use App\Model\Market\Entity\Categories\Setting\Setting;
use App\Model\Market\Entity\Categories\Setting\Template\Seo;
use App\Model\Market\Entity\Categories\Setting\Template\Template;
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
                new Seo()
            )
        );
    }
}
