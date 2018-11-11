<?php

namespace App\Controller\Site;

use App\Entity\Episode;
use App\Feed\Feed;
use App\Repository\EpisodeRepository;
use App\Repository\PodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractController
{
    public function home(EpisodeRepository $repository)
    {
        $episodes = $repository->findAllOrdered();

        return $this->render('site/home.html.twig', [
            'episodes' => $episodes,
        ]);

    }

    public function episode(Episode $episode)
    {
        return $this->render('site/episode.html.twig', [
            'episode' => $episode,
        ]);
    }

    public function rss(PodcastRepository $repository)
    {
        $podcast = $repository->find(1);

        $feed = (new Feed())->feed($podcast);

        return new Response($feed, 200, ['Content-Type' => 'application/rss+xml']);
    }
}
