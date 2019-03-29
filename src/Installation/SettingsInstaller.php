<?php

namespace App\Installation;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Doctrine\ORM\NoResultException;

class SettingsInstaller extends AbstractInstaller implements InstallerInterface
{
    private $respository;

    public function __construct(SettingRepository $repository)
    {
        $this->respository = $repository;
    }

    public function install() : string
    {
        $defaultSettings = Setting::DEFAULTS;

        try {
            if ($this->respository->findByName(Setting::SETTINGS_CREATED)) {
                throw new InstallerException("Settings have already been initialised");
            }
        } catch (NoResultException $exception) {
            foreach ($defaultSettings as $name => $value) {
                $setting = (new Setting)
                    ->setName($name)
                    ->setValue($value['default_value'])
                    ->setEditableFromDashboard($value['editable_from_dashboard'])
                    ->setType($value['type']);

                $this->respository->insert($setting);
            }

            $this->respository->update(
                [
                    'name' => Setting::SETTINGS_CREATED,
                    'value' => 'true',
                ]
            );

            return "Settings have now been initialised";
        }
    }
}
