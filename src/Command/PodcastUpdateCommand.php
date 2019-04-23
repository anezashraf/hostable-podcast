<?php

namespace App\Command;

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

class PodcastUpdateCommand extends Command
{
    use OptionTrait;

    protected static $defaultName = 'podcast:update';

    /**
     * @var PodcastRepository
     */
    private $podcastRepository;

    public function __construct(PodcastRepository $podcastRepository)
    {
        parent::__construct(static::$defaultName);
        $this->podcastRepository = $podcastRepository;
    }

    protected function configure()
    {

        $this
            ->setDescription('Add a short description for your command')
            ->setDefinition($this->getDefinitionFromEntity(new Podcast()));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $podcast = $this->podcastRepository->get();

        foreach ($podcast->updatableProperties() as $property) {
            if ($input->getOption($property)) {
                $methodName = 'set' . ucfirst($property);
                $podcast->$methodName($input->getOption($property));
            }
        }

        $this->podcastRepository->saveOrUpdate($podcast);
    }
}
