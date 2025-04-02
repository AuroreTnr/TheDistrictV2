<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Event\MessageEvent;
use App\Classe\Mail;
use App\Event\UserRegisteredEvent;
use Symfony\Bundle\SecurityBundle\Security;

class MailMessageSubscriber implements EventSubscriberInterface
{

    private $mail;
    private $security;

    public function __construct(Mail $mail, Security $security)
    {
        $this->mail = $mail;
        $this->security = $security;
    }


    public function onMessageEvent(UserRegisteredEvent $event): void
    {
        $user = $this->security->getUser();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisteredEvent::class => 'onMessageEvent',
        ];
    }
}
