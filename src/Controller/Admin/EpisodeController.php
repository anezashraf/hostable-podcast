<?php

namespace App\Controller\Admin;

use App\Entity\Episode;
use App\FileUploader\FileUploader;
use App\Form\EpisodeType;
use App\Repository\EpisodeRepository;
use App\Repository\PodcastRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeController extends AbstractController
{
    private $repository;
    private $podcastRepository;

    public function __construct(EpisodeRepository $repository, PodcastRepository $podcastRepository)
    {
        $this->repository = $repository;
        $this->podcastRepository = $podcastRepository;
    }

    public function index()
    {
        $episodes = $this->repository->findAll();

        return $this->render('admin/episode/index.html.twig', [
            'episodes' => $episodes ,
        ]);
    }

    public function update(Episode $episode)
    {
        $form = $this->createForm(EpisodeType::class, $episode);

        return $this->render('admin/episode/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function create()
    {
        $form = $this->createForm(EpisodeType::class);

        return $this->render('admin/episode/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function createSave(Request $request, FileUploader $fileUploader)
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $episode->setPodcast($this->podcastRepository->find(1));
            $episode->setPublishedAt(new DateTime('now'));
            $uploadedFile = $episode->getEnclosureUrl();
            $fileName = $fileUploader->upload($uploadedFile);
            $episode->setEnclosureUrl($fileName);
            $this->repository->saveOrUpdate($episode);
            return $this->redirectToRoute('admin_episodes');
        }
    }


    public function updateSave(Request $request, Episode $episode)
    {
        $form = $this->createForm(EpisodeType::class, $episode);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->saveOrUpdate($episode);
            return $this->redirectToRoute('admin_episodes');
        }
    }
}
