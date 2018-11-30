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
    public function home(PodcastRepository $repository)
    {
        $podcast = $repository->find(1);
        $episodes = $podcast->getEpisodes();

        return $this->render('site/index.html.twig', [
            'episodes' => $episodes,
            'podcast' => $podcast,
        ]);

    }

    public function episode(Episode $episode)
    {
        $podcast = $episode->getPodcast();

        return $this->render('site/index.html.twig', [
            'episodes' => [$episode],
            'podcast' => $podcast
        ]);
    }

    public function rss(PodcastRepository $repository)
    {
        $podcast = $repository->find(1);

        $feed = (new Feed())->feed($podcast);

        return new Response($feed, 200, ['Content-Type' => 'application/rss+xml']);
    }
}
