<?php

namespace App\Controller;

use App\Entity\ApiStructure;
use App\Entity\User;
use App\Form\UserRegisterationType;
use App\Patcher\Patcher;
use App\Repository\UserRepository;
use App\UserManagement\UserCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class UsersController extends AbstractController
{
    private $repository;
    private $serializer;
    private $userCreator;
    private $patcher;

    public function __construct(
        UserRepository $repository,
        SerializerInterface $serializer,
        Patcher $patcher,
        UserCreator $userCreator
    ) {
        $this->repository = $repository;
        $this->serializer = $serializer;
        $this->userCreator = $userCreator;
        $this->patcher = $patcher;
    }

    /**
     * @Route("/api/users", name="users")
     */
    public function index()
    {
        $users = $this->serializer->serialize($this->repository->findAll(), 'json', ['groups' => ['dashboard']]);

        return new JsonResponse($users, 200, [], true);
    }

    /**
     * @Route("/user/register/{invitationLink}", name="users_register", methods={"GET"})
     */
    public function register(string $invitationLink)
    {
        if ($this->userCreator->resolveInvitationLink($invitationLink)) {
            $form = $this->createForm(UserRegisterationType::class);

            return $this->render('login/register.twig', [
                'form' => $form->createView()
            ]);
        }

        return $this->render('login/register_fail.twig');
    }

    /**
     * @Route("/user/register/{invitationLink}", name="users_register_save", methods={"POST"})
     */
    public function save(Request $request, string $invitationLink)
    {
        $invitationLink = $this->userCreator->resolveInvitationLink($invitationLink);

        if ($invitationLink) {
            $form = $this->createForm(UserRegisterationType::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $this->userCreator->createUser($form->getData(), $invitationLink);

                return $this->render('login/success.twig',
                    [
                        'username' => $user->getUsername(),
                        'email' => $user->getEmail()
                    ]
                );
            }

            return $this->render('login/register.twig', [
                'form' => $form->createView()
            ]);

        }

        return $this->render('login/register_fail.twig');
    }


        /**
     * @Route("/api/users/invitation-link", name="invitation_link")
     */
    public function invitationLink()
    {

        $data = ['message' => $this->userCreator->initNewInvitationLink()];

        $data = $this->serializer->serialize(ApiStructure::create($data, new ConstraintViolationList), 'json', ['groups' => ['dashboard']]);

        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Route("/api/users/{id}", name="single_users")
     */
    public function single(int $id)
    {
        $user = $this->serializer->serialize($this->repository->get($id), 'json', ['groups' => ['dashboard']]);


        return new JsonResponse($user, 200, [], true);
    }

    /**
     * @Route("/api/user/{id}", name="episodes_save", methods={"PATCH"})
     */
    public function patch(Request $request, string $id)
    {
        $patchDocument = $request->getContent();
        $user = $this->repository->get($id);

        $errors = $this->patcher->makeChangesTo($user)
            ->using($patchDocument)
            ->run()
            ->getErrors();

        $this->repository->saveOrUpdate($user);

        $json = $this->serializer->serialize(
            ApiStructure::create($user, $errors),
            'json',
            ['groups' => ['dashboard']]
        );

        return new JsonResponse($json, 200, [], true);
    }
}
