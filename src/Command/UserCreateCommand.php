<?php

namespace App\Command;

use App\Entity\Setting;
use App\Entity\User;
use App\Repository\SettingRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'user:create';

    private $settingRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository, SettingRepository $settingRepository)
    {
        parent::__construct(null);

        $this->userRepository = $userRepository;
        $this->settingRepository= $settingRepository;
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

        if ($this->settingRepository->findByName(Setting::USER_INSERTED)) {

            $user = $this->userRepository->get();
            $io->error("a user has already been created with the username " . $user->getUsername());
            return;
        }

        $username = $io->ask("Please enter a username (this will appear on your rss feed as the podcast author)");
        $email = $io->ask("Please enter your email");

        $password = $io->askHidden("Please enter your password");
        $confirmPassword = $io->askHidden("Please re-enter your password");

        if ($password !== $confirmPassword) {
            $io->error("Passwords do not match, please try again");
        }


        $user = (new User)->setUsername($username)
            ->setEmail($email)
            ->setPassword($password);

        $this->userRepository->insert($user);
        $this->settingRepository->update(["name" => Setting::USER_INSERTED, "value" => 'true']);
    }
}
