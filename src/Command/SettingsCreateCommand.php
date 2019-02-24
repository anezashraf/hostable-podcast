<?php

namespace App\Command;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SettingsCreateCommand extends Command
{
    protected static $defaultName = 'settings:create';

    private $repository;

    public function __construct(SettingRepository $repository)
    {
        parent::__construct(null);

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

        $defaultSettings = Setting::DEFAULTS;

        try {

            if ($this->repository->findByName(Setting::SETTINGS_CREATED)) {

                $io->error("Settings have already been initialised");
                return;
            }
        } catch (NoResultException $exception) {
            foreach ($defaultSettings as $name => $value) {

                dump($value);
                $setting = (new Setting())
                    ->setName($name)
                    ->setValue($value['default_value'])
                    ->setEditableFromDashboard($value['editable_from_dashboard'])
                    ->setType($value['type']);

                $this->repository->insert($setting);
            }

            $this->repository->update(
                [
                    'name' => Setting::SETTINGS_CREATED,
                    'value' => 'true',
                ]
            );

            $io->success("Settings have now been initialised");
        }

    }
}
