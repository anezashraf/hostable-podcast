<?php

namespace App\Controller\Installation;

use App\Controller\Installation\Contracts\InstallationProcessInterface;
use App\Entity\Podcast;
use App\FileUploader\FileUploader;
use App\Form\PodcastType;
use App\Repository\PodcastRepository;
use App\Repository\SettingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class PodcastController extends AbstractController implements InstallationProcessInterface
{
    private $repository;
    private $settingRepository;
    private $userRepository;

    public function __construct(
        PodcastRepository $repository,
        SettingRepository $settingRepository,
        UserRepository $userRepository
    )
    {
        $this->repository = $repository;
        $this->settingRepository = $settingRepository;
        $this->userRepository = $userRepository;
    }

    public function podcast()
    {
        if ($this->settingRepository->findByName('doesPodcastInformationExist')) {
            return $this->redirectToRoute('index');
        }

        $form = $this->createForm(PodcastType::class);
        return $this->render('installation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function podcastSubmit(Request $request)
    {
        $podcast = new Podcast();
        $form = $this->createForm(PodcastType::class, $podcast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $podcast->setUser($this->userRepository->find(1));
            $this->repository->update($podcast);
            $this->settingRepository->update(['name' => 'doesPodcastInformationExist', 'value' => 'true']);
            return $this->redirectToRoute('index');
        }

        return $this->redirectToRoute("installation_process_podcast");
    }
}
