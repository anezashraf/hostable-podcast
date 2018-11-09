<?php

namespace App\Controller\Admin;

use App\Entity\Podcast;
use App\Form\PodcastType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PodcastController extends AbstractController
{
    public function index(Podcast $podcast)
    {
        $form = $this->createForm(PodcastType::class, $podcast);

        return $this->render('podcast/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
