<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class UserChangePasswordCommand
 * @package App\Command
 */
final class UserChangePasswordCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'user:change-password';

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserChangePasswordCommand constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct(null);

        $this->userRepository = $userRepository;
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Changes the password of the super admin');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
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

            return 0;
        }

        $io->error("Passwords do not match");
    }
}
