<?php

namespace App\Controller;

use App\Feed\Feed;
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
    private $episodeRepository;
    private $targetDirectory;

    public function __construct(
        PodcastRepository $repository,
        EpisodeRepository $episodeRepository,
        SettingRepository $settingRepository,
        string $targetDirectory
    ) {
        $this->repository = $repository;
        $this->settingsRepository = $settingRepository;
        $this->episodeRepository = $episodeRepository;
        $this->targetDirectory = $targetDirectory;
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
            $limit = 10;
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

    /**
     * @Route("/subscribe.rss", name="subscribe")
     */
    public function subscribe()
    {
        $podcast = $this->repository->get();

        $content = (new Feed())->feed($podcast, 'localhost:8000');

        return new Response($content, 200, ['Content-Type' => 'application/rss+xml']);
    }

    /**
     * @Route("/episode/{slug}.mp3", name="download")
     */
    public function download(string $slug)
    {
        /**@var \App\Entity\Episode **/
        $episode = $this->repository->getBySlug($slug);

        return $this->file($this->targetDirectory . $episode->getEnclosureUrl(), $episode->getTitle() . '.mp3');
    }
}
