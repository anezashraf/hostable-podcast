<?php

namespace App\Installation;

use App\Entity\Podcast;
use App\Entity\Setting;
use App\Repository\PodcastRepository;
use App\Repository\SettingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NoResultException;

class PodcastInstaller extends AbstractInstaller implements InstallerInterface
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PodcastRepository
     */
    private $podcastRepository;

    public function __construct(
        SettingRepository $repository,
        PodcastRepository $podcastRepository,
        UserRepository $userRepository
    ) {
        $this->settingRepository = $repository;
        $this->userRepository = $userRepository;
        $this->podcastRepository = $podcastRepository;
    }

    public function install() : string
    {
        if ($this->settingRepository->findByName(Setting::PODCAST_INSERTED)) {
            throw new InstallerException("Podcast has already been created");
        }

        $name = $this->findAnswer("name");
        $description = $this->findAnswer("description");

        $podcast = (new Podcast)
            ->setTitle($name)
            ->setDescription($description);

        $podcast->setUser($this->userRepository->get());

        $this->podcastRepository->update($podcast);
        $this->settingRepository->update(['name' => Setting::PODCAST_INSERTED, 'value' => 'true']);

        return "Podcast has now been created";
    }

    public function getQuestions(): array
    {
        $nameQuestion = new InstallQuestion("What title would you like to give to your podcast?");
        $descriptionQuestion = new InstallQuestion("Please provide a small description for your podcast");
        $nameQuestion->setName("name");
        $descriptionQuestion->setName("description");

        return [$nameQuestion, $descriptionQuestion];
    }
}
