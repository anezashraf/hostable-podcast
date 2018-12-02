<?php

namespace App\Controller\Admin;

use App\Entity\Episode;
use App\FileUploader\FileUploader;
use App\Form\EpisodeEnclosureUrlUploadType;
use App\Form\EpisodeType;
use App\Repository\EpisodeRepository;
use App\Repository\PodcastRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class EpisodeController extends AbstractController
{
    private $repository;
    private $podcastRepository;
    private $fileuploader;

    public function __construct(EpisodeRepository $repository, PodcastRepository $podcastRepository, FileUploader $fileUploader)
    {
        $this->repository = $repository;
        $this->podcastRepository = $podcastRepository;
        $this->fileuploader = $fileUploader;
    }

    public function index()
    {
        $episodes = $this->repository->findAllOrdered();

        return $this->render('admin/episode/index.html.twig', [
            'episodes' => $episodes ,
        ]);
    }

    public function update(Episode $episode)
    {
        $form = $this->createForm(EpisodeType::class, $episode);
        $enclosureUrlUpload = $this->createForm(EpisodeEnclosureUrlUploadType::class, $episode);

        return $this->render('admin/episode/edit.html.twig', [
            'form' => $form->createView(),
            'enclosureUrlUpload' => $enclosureUrlUpload->createView(),
            'episode' => $episode,
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

    public function upload(Request $request, Episode $episode)
    {
        $form = $this->createForm(EpisodeEnclosureUrlUploadType::class, $episode);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $episode->getEnclosureUrl();
            $fileName = $this->fileuploader->upload($uploadedFile);
            $episode->setEnclosureUrl($fileName);
            $this->repository->saveOrUpdate($episode);
            return $this->redirectToRoute('admin_show_episode', ['id' => $episode->getId()]);
        }

    }
}
