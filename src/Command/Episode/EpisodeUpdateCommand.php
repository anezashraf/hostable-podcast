<?php

namespace App\Command\Episode;

use App\Command\AbstractUpdateCommand;
use App\Command\Common\EntityUpdaterTrait;
use App\Command\Common\OptionTrait;
use App\Entity\Episode;
use Symfony\Component\Console\Input\InputArgument;

class EpisodeUpdateCommand extends AbstractUpdateCommand
{
    protected static $defaultName = 'episode:update';

    public function getEntity()
    {
        return new Episode;
    }

    public function getArgument() : ?InputArgument
    {
        return new InputArgument("id", InputArgument::REQUIRED);
    }

    public function getFileProperties()
    {
        return ['enclosure', 'image'];
    }
}
