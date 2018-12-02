<?php

namespace App\Controller\Admin;

use App\Entity\Podcast;
use App\FileUploader\FileUploader;
use App\Form\PodcastImageUploadType;
use App\Form\PodcastType;
use App\Repository\PodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PodcastController extends AbstractController
{
    private $fileUploader;

    public function __construct(PodcastRepository $repository, FileUploader $fileUploader)
    {
        $this->repository = $repository;
        $this->fileUploader = $fileUploader;
    }

    public function index(Podcast $podcast)
    {
        $form = $this->createForm(PodcastType::class, $podcast);
        $imageUpload = $this->createForm(PodcastImageUploadType::class, $podcast);

        return $this->render('admin/podcast/index.html.twig', [
            'form' => $form->createView(),
            'imageUpload' => $imageUpload->createView(),
            'podcast' => $podcast,
        ]);
    }

    public function save(Request $request, Podcast $podcast)
    {
        $form = $this->createForm(PodcastType::class, $podcast);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->saveOrUpdate($podcast);
            return $this->redirectToRoute('admin_podcast', ['id' => $podcast->getId()]);
        }

    }

    public function upload(Request $request, Podcast $podcast)
    {
        $form = $this->createForm(PodcastImageUploadType::class, $podcast);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $podcast->getImage();
            $fileName = $this->fileUploader->upload($uploadedFile);
            $podcast->setImage($fileName);
            $this->repository->saveOrUpdate($podcast);
            return $this->redirectToRoute('admin_podcast', ['id' => $podcast->getId()]);
        }

    }
}
