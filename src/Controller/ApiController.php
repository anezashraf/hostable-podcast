<?php

namespace App\Controller;

use App\Response\ApiStructure;
use App\Entity\EntityInterface;
use App\Entity\Episode;
use App\File\FileUploader;
use App\Patcher\Patcher;
use App\Repository\Contracts\RepositoryInterface;
use App\UserManagement\UserCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @var Patcher
     */
    protected $patcher;

    /**
     * @var UserCreator
     */
    private $userCreator;

    /**
     * @var FileUploader
     */
    private $fileUploader;

    public function __construct(Patcher $patcher, UserCreator $userCreator, FileUploader $fileUploader)
    {
        $this->patcher = $patcher;
        $this->userCreator = $userCreator;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Route("/api/{entity}/{id}", name="patch", methods={"PATCH"}, requirements={
     *         "entity": "user|setting|episode|podcast"
     *     })
     */
    public function patch(Request $request, string $entity, string $id)
    {
        $patchDocument = $request->getContent();
        $episode = $this->getRepository($entity)->get($id);

        $errors = $this->patcher->makeChangesTo($episode)
            ->using($patchDocument)
            ->run()
            ->getErrors();

        $this->getRepository($entity)->saveOrUpdate($episode);

        return $this->renderApiResponse($episode, $errors);
    }

    /**
     * @Route("/api/{entity}", name="get_all", methods={"GET"}, requirements={
     *         "entity": "user|setting|episode|podcast"
     *     })
     */
    public function getAll(string $entity)
    {
        $repository = $this->getRepository($entity);

        $entities = $repository->getAll();

        return $this->renderApiResponse($entities, new ConstraintViolationList);
    }

    protected function renderApiResponse($episode, $errors)
    {
        $json = $this->container->get('serializer')->serialize(
            ApiStructure::create($episode, $errors),
            'json',
            ['groups' => ['dashboard']]
        );

        return new JsonResponse($json, 200, [], true);
    }

    protected function getRepository(string $entity) : RepositoryInterface
    {
        $className = "App\\Entity\\" . ucfirst($entity);

        return $this->container->get('doctrine')->getRepository($className);
    }


    /**
     * @Route("/api/fileupload/{entityName}/{id}/{type}", name="file_upload")
     */
    public function index(Request $request, string $entityName, string $id, string $type)
    {
        $file = $request->files->get('file');
        $repository = $this->getRepository($entityName);

        $fileName = $this->fileUploader->upload($file);

        $entity = $repository->find($id);

        $methodName = "set" . ucfirst($type);
        $entity->$methodName($fileName);

        $repository->saveOrUpdate($entity);

        return $this->renderApiResponse($entity, new ConstraintViolationList);
    }

    /**
     * @Route("/api/users/invitation-link", name="invitation_link")
     */
    public function invitationLink()
    {
        $data = ['message' => $this->userCreator->initNewInvitationLink()];

        return $this->renderApiResponse($data, new ConstraintViolationList);
    }

    /**
     * @Route("/api/episodes", name="episodes_new", methods={"PUT"})
     */
    public function saveNew(Request $request)
    {
        $json = $request->getContent();

        $episode = $this->container->get('serializer')->deserialize(
            $json,
            Episode::class,
            'json',
            ['groups' => ['dashboard']
            ]
        );

        $this->getRepository('episode')->saveOrUpdate($episode);

        return $this->renderApiResponse($episode, new ConstraintViolationList);
    }
}
