<?php

namespace App\Command;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpCommand extends Command
{
    protected static $defaultName = 'up';
    private $repository;

    public function __construct(SettingRepository $settingRepository)
    {
        parent::__construct(null);

        $this->repository = $settingRepository;
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
        $symfonyOutput = new SymfonyStyle($input, $output);

        if (! $this->repository->findByName(Setting::IS_ONLINE)) {
            $this->repository->update(['name' => Setting::IS_ONLINE, 'value' => 'true']);
            $symfonyOutput->warning('Your website is already up and available to the public');


            return 0;
        }
    }
}
