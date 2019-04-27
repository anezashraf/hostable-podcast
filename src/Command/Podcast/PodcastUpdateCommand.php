<?php

namespace App\Command\Podcast;

use App\Command\AbstractUpdateCommand;
use App\Command\Common\EntityUpdaterTrait;
use App\Command\Common\OptionTrait;
use App\Entity\Podcast;
use App\Repository\PodcastRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PodcastUpdateCommand extends AbstractUpdateCommand
{

    protected static $defaultName = 'podcast:update';

    public function getEntity()
    {
        return new Podcast();
    }

    public function getArgument(): ?InputArgument
    {
        return null;
    }
}
