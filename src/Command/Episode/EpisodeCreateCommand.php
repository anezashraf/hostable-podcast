<?php

namespace App\Command\Episode;

use App\Command\Common\EntityUpdaterTrait;
use App\Command\Common\OptionTrait;
use App\File\FileParserFactory;
use App\Entity\Episode;
use App\Repository\EpisodeRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EpisodeCreateCommand extends Command
{
    use OptionTrait;
    use EntityUpdaterTrait;

    protected static $defaultName = 'episode:create';
    private $episodeRepository;

    public function __construct(EpisodeRepository $episodeRepository)
    {
        parent::__construct(null);

        $this->episodeRepository = $episodeRepository;
    }

    protected function configure()
    {
        $def = new InputDefinition();

        $def->addOptions($this->getOptionsFromEntity(new Episode));
        $this->setDefinition($def);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $episode = $this->updateEntity(new Episode, $input, ['image', 'enclosure']);

        $this->episodeRepository->saveOrUpdate($episode);
    }
}
