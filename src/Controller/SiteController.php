<?php

namespace App\Controller;

use App\Repository\EpisodeRepository;
use App\Repository\PodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
