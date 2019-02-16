<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    /**
     * @Route("/api/fileupload/{entityName}/{id}/{type}", name="file_upload")
     */
    public function index(Request $request, string $entityName, string $id, string $type)
    {
        $file = $request->files->get('file');
        $className = "App\\Entity\\" . $entityName;
        $repository = $this->entityManager->getRepository($className);

        $entity = $repository->find($id);

        $methodName = "set" . ucfirst($type);
        $entity->$methodName($file);


        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    }
}
