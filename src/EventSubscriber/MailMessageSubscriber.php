<?php

namespace App\EventSubscriber;


use App\Classe\Mail;
use App\Entity\Commande;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class MailMessageSubscriber implements EventSubscriber
{

    private $mail;
    private $commande;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }



    public function getSubscribedEvents(): array
    {
        return [
            'postPersist'
        ];
    }


    public function postPersist(PostPersistEventArgs $args, Commande $commande)
    {
        $entity = $args->getObject();

        if ($entity instanceof Commande && $commande->getStatus() == 2) {
            $this->mail->send('tournieraurore@orange.fr', 'John', 'test event doctrine', 'commande_status_3.html', null);
        }
    }



}
