<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\User;
use App\Patcher\Patcher;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\ApiStructure;
use Symfony\Component\Validator\ConstraintViolationList;

class EpisodeController extends AbstractController
{
    private $repository;
    private $serializer;
    private $patcher;

    public function __construct(
        EpisodeRepository $repository,
        SerializerInterface $serializer,
        Patcher $patcher
    ) {
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->patcher = $patcher;
    }

    /**
     * @Route("/api/episodes", name="episodes", methods={"GET"})
     */
    public function index()
    {
        $episodes = $this->repository->findAllOrdered();

        $json = $this->serializer->serialize(
            ApiStructure::create($episodes, new ConstraintViolationList),
            'json',
            ['groups' => ['dashboard']]
        );

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/episodes", name="episodes_new", methods={"PUT"})
     */
    public function saveNew(Request $request)
    {
        $json = $request->getContent();

        $episode = $this->serializer->deserialize(
            $json,
            Episode::class,
            'json',
            ['groups' => ['dashboard']
            ]
        );

        $this->repository->saveOrUpdate($episode);

        $json = $this->serializer->serialize($episode, 'json', ['groups' => ['dashboard']]);
        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/episode/{id}", name="episodes_save", methods={"PATCH"})
     */
    public function save(Request $request, string $id)
    {
        $patchDocument = $request->getContent();
        $episode = $this->repository->get($id);

        $errors = $this->patcher->makeChangesTo($episode)
            ->using($patchDocument)
            ->run()
            ->getErrors();

        $this->repository->saveOrUpdate($episode);

        $json = $this->serializer->serialize(
            ApiStructure::create($episode, $errors),
            'json',
            ['groups' => ['dashboard']]
        );

        return new JsonResponse($json, 200, [], true);
    }
}
