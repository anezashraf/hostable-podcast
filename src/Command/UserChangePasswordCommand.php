<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserChangePasswordCommand extends Command
{
    protected static $defaultName = 'user:change-password';
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct(null);

        $this->userRepository = $userRepository;
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

        $user = $this->userRepository->get();

        $io->caution(
            "You're about to change the password of the user " .
            $user->getUsername() . "/" . $user->getEmail()
        );

        $password = $io->askHidden('Please enter your new password');
        $confirmPassword = $io->askHidden('Please re-enter your password');

        if ($password === $confirmPassword) {
            $user->setPassword($password);
            $this->userRepository->saveOrUpdate($user);

            return;
        }

        $io->error("Passwords do not match");
    }
}
