<?php

namespace App\Controller\Installation;

use App\Controller\Contacts\InstallationProcessInterface;
use App\Entity\Podcast;
use App\Entity\Setting;
use App\Form\PodcastType;
use App\Form\UserType;
use App\Repository\PodcastRepository;
use App\Repository\SettingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController implements InstallationProcessInterface
{
    private $repository;
    private $router;
    private $settingRepository;

    public function __construct(UserRepository $repository, SettingRepository $settingRepository)
    {
        $this->repository = $repository;
        $this->settingRepository = $settingRepository;
    }

    public function user()
    {
        if ($this->settingRepository->findByName('doesUserInformationExist')) {
            return $this->redirectToRoute('index');
        }

        $form = $this->createForm(UserType::class);
        return $this->render('installation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function userSubmit(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $this->repository->update($user);
            $this->settingRepository->update(['name' => 'doesUserInformationExist', 'value' => 'true']);
            return $this->redirectToRoute('index');

        }
    }
}
