<?php

namespace App\Controller;

use App\Repository\EpisodeRepository;
use App\Repository\PodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    private $repository;
    private $episodeRepository;

    public function __construct(PodcastRepository $repository, EpisodeRepository $episodeRepository)
    {
        $this->repository = $repository;
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * @Route("/", name="site")
     */
    public function index()
    {
        $podcast = $this->repository->getWithEpisodes();

        return $this->render('site/index.html.twig', [
            'podcast' => $podcast,
        ]);
    }

    /**
     * @Route("/episode/{slug}", name="site_episode")
     */
    public function episode(string $slug)
    {
        $episode = $this->episodeRepository->getBySlug($slug);

        return $this->render('site/episode.html.twig', [
            'episode' => $episode,
        ]);
    }
}
