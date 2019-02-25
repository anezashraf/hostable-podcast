<?php

namespace App\Controller;

use App\Entity\ApiStructure;
use App\Entity\Podcast;
use App\Patcher\Patcher;
use App\Repository\PodcastRepository;
use Rs\Json\Patch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PodcastController extends AbstractController
{
    private $repository;
    private $serializer;
    private $patcher;

    public function __construct(
        PodcastRepository $repository,
        SerializerInterface $serializer,
        Patcher $patcher
    ) {
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->patcher = $patcher;
    }

    /**
     * @Route("/api/podcast", name="podcast", methods={"GET"})
     */
    public function index()
    {
        $podcast = $this->repository->get();

        $json = $this->serializer->serialize(
            ApiStructure::create(
                $podcast,
                new ConstraintViolationList
            ),
            'json',
            ['groups' => ['dashboard']]
        );

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/podcast", name="podcast_save", methods={"PATCH"})
     */
    public function save(Request $request)
    {
        $patchDocument = $request->getContent();
        $podcast = $this->repository->get();

        $errors = $this->patcher->makeChangesTo($podcast)
            ->using($patchDocument)
            ->run()
            ->getErrors();

        $this->repository->saveOrUpdate($podcast);

        $json = $this->serializer->serialize(
            ApiStructure::create($podcast, $errors),
            'json',
            ['groups' => ['dashboard']]
        );

        return new JsonResponse($json, 200, [], true);
    }
}
