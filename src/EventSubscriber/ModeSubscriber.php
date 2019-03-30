<?php

namespace App\EventSubscriber;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class ModeSubscriber
 * @package App\EventSubscriber
 */
class ModeSubscriber implements EventSubscriberInterface
{
    /**
     * @var SettingRepository
     */
    private $repository;

    /**
     * ModeSubscriber constructor.
     * @param SettingRepository $repository
     */
    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param GetResponseEvent $event
     * @throws \Doctrine\ORM\NoResultException
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($this->repository->findByName(Setting::IS_ONLINE)) {
            return;
        }

        $event->setResponse(
            new Response("Podcast is not online", 503)
        );
        $event->stopPropagation();
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
           'kernel.request' => 'onKernelRequest',
        ];
    }
}
