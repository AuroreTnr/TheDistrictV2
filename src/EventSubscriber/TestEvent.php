<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TestEvent implements EventSubscriberInterface
{


    public function ditcoucou(ControllerEvent $event): void
    {
        die('je suis un eventListener');
    }

    public function autre(ControllerEvent $event): void
    {
        die('je suis un eventListener sur autre');
    }


    public static function getSubscribedEvents(): array
    {

    
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::CONTROLLER => 'ditcoucou'
        ];
    }


}