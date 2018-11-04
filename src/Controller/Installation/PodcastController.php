<?php

namespace App\Controller\Installation;

use App\Controller\Contacts\InstallationProcessInterface;
use App\Entity\Podcast;
use App\Entity\Setting;
use App\Form\PodcastType;
use App\Form\UserType;
use App\Repository\PodcastRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

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
        $form = $this->createForm(PodcastType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $podcast = $form->getData();
            $this->settingRepository->update(['name' => 'doesPodcastInformationExist', 'value' => 'true']);
            $this->repository->update($podcast);
            return $this->redirectToRoute('installation_process_user');
        }
    }
}
