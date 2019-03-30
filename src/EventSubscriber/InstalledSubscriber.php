<?php

namespace App\EventSubscriber;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class InstalledSubscriber
 * @package App\EventSubscriber
 */
class InstalledSubscriber implements EventSubscriberInterface
{
    /**
     * @var SettingRepository
     */
    private $repository;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * InstalledSubscriber constructor.
     * @param SettingRepository $repository
     * @param EngineInterface $engine
     */
    public function __construct(SettingRepository $repository, EngineInterface $engine)
    {
        $this->repository = $repository;
        $this->engine = $engine;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {

        $messages = [];

        try {
            if (! $this->repository->findByName(Setting::USER_INSERTED)) {
                $messages[] = 'You need to create a user, please run php bin/console user:create';
            }
        } catch (NoResultException $exception) {
            $messages[] = 'Please run php bin/console settings:create';
        }



        if (count($messages) > 0) {
            $event->setResponse(
                new Response(
                    $this->engine->render('installation/index.html.twig', ['messages' => $messages]),
                    503
                )
            );

            $event->stopPropagation();
        }
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
