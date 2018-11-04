<?php

namespace App\EventSubscriber;

use App\Controller\Contacts\InstallationProcessInterface;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;

class HasBeenInstalledSubscriber implements EventSubscriberInterface
{
    private $repository;
    private $router;

    public function __construct(SettingRepository $repository, RouterInterface $router)
    {
        $this->repository = $repository;
        $this->router = $router;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if ($this->repository->findByName('hasBeenInstalled')) {
            return;
        }

        $controller = $event->getController()[0];

        if (! $controller instanceof InstallationProcessInterface && ! $controller instanceof ExceptionController) {

            if (! $this->repository->findByName('doesPodcastInformationExist')) {
                $event->setController(function() {
                    return new RedirectResponse($this->router->generate('installation_process_podcast'));
                });


                $event->stopPropagation();
                return;
            }

            if (! $this->repository->findByName('doesUserInformationExist')) {

                $event->setController(function() {
                    return new RedirectResponse($this->router->generate('installation_process_user'));
                });


                $event->stopPropagation();
                return;
            }

        }
    }


    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
