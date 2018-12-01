<?php

namespace App\Controller\Installation;

use App\Controller\Installation\Contracts\InstallationProcessInterface;
use App\Entity\Podcast;
use App\FileUploader\FileUploader;
use App\Form\PodcastType;
use App\Repository\PodcastRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PodcastController extends AbstractController implements InstallationProcessInterface
{
    private $repository;
    private $settingRepository;

    public function __construct(PodcastRepository $repository, SettingRepository $settingRepository)
    {
        $this->repository = $repository;
        $this->settingRepository = $settingRepository;
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
            $this->repository->update($podcast);
            $this->settingRepository->update(['name' => 'doesPodcastInformationExist', 'value' => 'true']);
            return $this->redirectToRoute('installation_process_user');
        }

        dd($form);
    }
}
