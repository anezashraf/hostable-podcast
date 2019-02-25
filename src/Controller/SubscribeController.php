<?php

namespace App\Controller;

use App\Feed\Feed;
use App\Repository\PodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends AbstractController
{
    private $repository;

    public function __construct(PodcastRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/subscribe.rss", name="subscribe")
     */
    public function index()
    {
        $podcast = $this->repository->get();

        $content = (new Feed())->feed($podcast, 'localhost:8000');

        return new Response($content, 200, ['Content-Type' => 'application/rss+xml']);
    }
}
