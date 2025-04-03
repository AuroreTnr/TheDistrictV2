<?php

namespace App\EventSubscriber;


use App\Classe\Mail;
use App\Entity\Commande;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostPersistEventArgs;



class MailMessageSubscriber implements EventSubscriber
{

    private $mail;

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


    
    public function postPersist(PostPersistEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Commande) {
            $this->mail->send('tournieraurore@orange.fr', 'Bernadette', 'test event doctrine', 'commande_status_3.html', null);
        }
    }



}
