<?php

namespace App\Controller;

use App\Repository\PodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    private $repository;

    public function __construct(PodcastRepository $repository)
    {
        $this->repository = $repository;
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
}
