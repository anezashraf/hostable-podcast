<?php

namespace App\DataFixtures;

use App\Entity\Setting;
use App\Setting\SettingDefaults;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SettingFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $settingDefaults = SettingDefaults::DEFAULTS;

        $settingDefaults[SettingDefaults::USER_INSERTED]['default_value'] = 'true';
        $settingDefaults[SettingDefaults::PODCAST_INSERTED]['default_value'] = 'true';
        $settingDefaults[SettingDefaults::SETTINGS_CREATED]['default_value'] = 'true';
        $settingDefaults[SettingDefaults::IS_ONLINE]['default_value'] = 'true';

        foreach ($settingDefaults as $name => $value) {
            $setting = (new Setting)
                ->setName($name)
                ->setEditableFromDashboard($value['editable_from_dashboard'])
                ->setValue($value['default_value'])
                ->setType($value['type']);


            $manager->persist($setting);
        }

        $manager->flush();
    }
}
