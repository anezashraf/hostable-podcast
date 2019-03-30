<?php

namespace App\Installation;

use App\Entity\Setting;
use App\Entity\User;
use App\Repository\SettingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NoResultException;

class UserInstaller extends AbstractInstaller implements InstallerInterface
{
    private $userRespository;
    private $settingRepository;

    public function __construct(UserRepository $userRepository, SettingRepository $settingRepository)
    {
        $this->userRespository = $userRepository;
        $this->settingRepository = $settingRepository;
    }

    public function install() : string
    {
        if ($this->settingRepository->findByName(Setting::USER_INSERTED)) {
            $user = $this->userRespository->get();
            throw new InstallerException(
                "a user has already been created with the username "
                .
                $user->getUsername()
            );
        }

        $username = $this->findAnswer("username");
        $email = $this->findAnswer("email");
        $password = $this->findAnswer("password");
        $confirmPassword = $this->findAnswer("confirm_password");

        if ($password !== $confirmPassword) {
            print_r($password);
            print_r($confirmPassword);
            throw new InstallerException("Passwords do not match");
        }

        $user = (new User)->setUsername($username)
            ->setEmail($email)
            ->setRoles(['ROLE_ADMIN'])
            ->setEnabled(true)
            ->setPassword($password);

        $this->userRespository->insert($user);
        $this->settingRepository->update(["name" => Setting::USER_INSERTED, "value" => 'true']);

        return "User has been created";
    }

    public function getQuestions(): array
    {
        $username = new InstallQuestion("Please enter a username (this will appear on your rss feed as the
             podcast author)");

        $username->setName("username");

        $email = new InstallQuestion("Please enter your email");
        $email->setName("email");

        $password = new InstallQuestion("Please enter your password");
        $password->setName("password");
        $password->setHidden(true);

        $confirmPassword = new InstallQuestion("Please re-enter your password");
        $confirmPassword->setName("confirm_password");
        $confirmPassword->setHidden(true);

        return [
            $username,
            $email,
            $password,
            $confirmPassword
        ];
    }
}
