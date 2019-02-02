<?php

namespace App\Command;

use App\Entity\Podcast;
use App\Entity\Setting;
use App\Repository\PodcastRepository;
use App\Repository\SettingRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PodcastCreateCommand extends Command
{
    protected static $defaultName = 'podcast:create';
    private $repository;
    private $settingsRepository;
    private $userRepository;

    public function __construct(
        PodcastRepository $repository,
        SettingRepository $settingRepository,
        UserRepository $userRepository
    ) {
        parent::__construct(null);

        $this->settingsRepository = $settingRepository;
        $this->userRepository = $userRepository;
        $this->repository = $repository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if ($this->settingsRepository->findByName(Setting::PODCAST_INSERTED)) {

            $io->error("Podcast has already been created");
            return;
        }

        $name = $io->ask("What title would you like to give to your podcast?");
        $description = $io->ask("Please provide a small description for your podcast");

        $podcast = (new Podcast)
            ->setTitle($name)
            ->setDescription($description);

        $podcast->setUser($this->userRepository->get());

        $this->repository->update($podcast);
        $this->settingsRepository->update(['name' => Setting::PODCAST_INSERTED, 'value' => 'true']);

    }
}
