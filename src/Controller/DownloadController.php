<?php

namespace App\Controller;

use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    /**
     * @var EpisodeRepository
     */
    private $repository;
    private $targetDirectory;

    public function __construct(EpisodeRepository $repository, string $targetDirectory)
    {
        $this->repository = $repository;
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @Route("/episode/{slug}.mp3", name="download")
     */
    public function index(string $slug)
    {
        /**@var \App\Entity\Episode **/
        $episode = $this->repository->getBySlug($slug);

        return $this->file($this->targetDirectory . $episode->getEnclosureUrl(), $episode->getTitle() . '.mp3');
    }
}
