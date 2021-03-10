<?php

declare(strict_types=1);

namespace App\DataFixtures\Blog\Posts;

use App\Model\Blog\Entity\Posts\Setting\Id;
use App\Model\Blog\Entity\Posts\Setting\Setting;
use App\Model\Blog\Entity\Posts\Setting\Template\Meta;
use App\Model\Blog\Entity\Posts\Setting\Template\Seo;
use App\Model\Blog\Entity\Posts\Setting\Template\Template;
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
                new Seo(),
                new Meta()
            )
        );
    }
}
