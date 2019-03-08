<?php

namespace App\Controller;

use App\Entity\ApiStructure;
use App\File\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class FileController extends AbstractController
{

    private $entityManager;
    private $fileUploader;
    private $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        FileUploader $fileUploader
    ) {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/fileupload/{entityName}/{id}/{type}", name="file_upload")
     */
    public function index(Request $request, string $entityName, string $id, string $type)
    {
        $file = $request->files->get('file');
        $className = "App\\Entity\\" . ucfirst($entityName);
        $repository = $this->entityManager->getRepository($className);

        $fileName = $this->fileUploader->upload($file);

        $entity = $repository->find($id);

        $methodName = "set" . ucfirst($type);
        $entity->$methodName($fileName);

        $repository->saveOrUpdate($entity);

        $json = $this->serializer->serialize(
            ApiStructure::create(
                $entity,
                new ConstraintViolationList
            ),
            'json',
            ['groups' => ['dashboard']
            ]
        );

        return new JsonResponse($json, 200, [], true);
    }
}
