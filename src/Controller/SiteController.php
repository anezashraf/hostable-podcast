<?php

namespace App\Controller;

use App\Repository\EpisodeRepository;
use App\Repository\PodcastRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    private $repository;
    private $settingsRepository;

    public function __construct(PodcastRepository $repository, SettingRepository $settingRepository)
    {
        $this->repository = $repository;
        $this->settingsRepository = $settingRepository;
    }

    /**
     * @Route("/", name="site")
     * @Route("/all", name="site_all")
     *
     * @return Response
     */
    public function index(Request $request, ?int $limit = null)
    {
        if ($request->get('_route') === 'site') {
            $limit = 5;
        }

        $podcast = $this->repository->getWithEpisodes($limit);
        $settings = $this->settingsRepository->findAll();

        return $this->render('site/index.html.twig', [
            'podcast' => $podcast,
            'settings' => $settings
        ]);
    }

    /**
     * @Route("/episode/{slug}", name="site_episode")
     */
    public function episode(string $slug)
    {
        $podcast = $this->repository->getWithEpisode($slug);
        $settings = $this->settingsRepository->findAll();


        return $this->render('site/index.html.twig', [
            'podcast' => $podcast,
            'settings' => $settings

        ]);
    }
}
