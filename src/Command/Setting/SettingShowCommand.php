<?php

namespace App\Command\Setting;

use App\Command\AbstractShowCommand;
use App\Entity\Podcast;
use App\Entity\Setting;

class SettingShowCommand extends AbstractShowCommand
{
    protected static $defaultName = 'setting:show';

    public function getEntity()
    {
        return new Setting();
    }

    public function canAcceptArgument()
    {
        return true;
    }

    public function getTableHeaders()
    {
        return [
            'name',
            'value',
        ];
    }

    public function getTableRows($entities)
    {
        return [
            $entities->getName(),
            $entities->getValue(),
        ];
    }
}
