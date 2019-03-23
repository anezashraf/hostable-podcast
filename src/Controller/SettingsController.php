<?php

namespace App\Controller;

use App\Entity\ApiStructure;
use App\Patcher\Patcher;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SettingsController extends AbstractController
{
    private $repository;
    private $serializer;
    private $patcher;

    public function __construct(
        SettingRepository $repository,
        SerializerInterface $serializer,
        Patcher $patcher
    ) {
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->patcher = $patcher;
    }

    /**
     * @Route("/api/settings", name="settings")
     */
    public function index()
    {
        $settings = $this->repository->getAll();

        $json = $this->serializer->serialize($settings, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/settings/{id}", name="settings_save", methods={"PATCH"})
     */
    public function save(Request $request, string $id)
    {
        $patchDocument = $request->getContent();
        $setting = $this->repository->get($id);

        $errors = $this->patcher->makeChangesTo($setting)
            ->using($patchDocument)
            ->run()
            ->getErrors();

        $this->repository->saveOrUpdate($setting);

        $json = $this->serializer->serialize(
            ApiStructure::create($setting, $errors),
            'json',
            ['groups' => ['dashboard']]
        );

        return new JsonResponse($json, 200, [], true);
    }
}
