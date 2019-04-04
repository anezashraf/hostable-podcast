<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\ApiStructure;
use App\Entity\User;
use App\Form\UserRegisterationType;
use App\Patcher\Patcher;
use App\Repository\UserRepository;
use App\UserManagement\UserCreator;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class LoginController
 * @package App\Controller\Login
 */
class UserController extends AbstractController
{

    private $repository;
    private $serializer;
    private $patcher;
    private $userCreator;

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
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.twig', ['last_username' => $lastUsername, 'error' => $error]);
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

                return $this->render(
                    'login/success.twig',
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
}
