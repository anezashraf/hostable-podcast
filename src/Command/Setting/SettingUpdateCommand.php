<?php

namespace App\Command\Setting;

use App\Command\AbstractUpdateCommand;
use App\Command\Common\EntityUpdaterTrait;
use App\Command\Common\OptionTrait;
use App\Entity\Podcast;
use App\Entity\Setting;
use App\Repository\PodcastRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SettingUpdateCommand extends AbstractUpdateCommand
{

    protected static $defaultName = 'setting:update';

    public function getEntity()
    {
        return new Setting;
    }

    public function getArgument(): ?InputArgument
    {
        return new InputArgument("name", InputArgument::REQUIRED);
    }
}
