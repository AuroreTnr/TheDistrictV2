<?php

namespace App\Classe;

use Exception;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class SetEmail
{

    private $mailer;
    private $url;

    public function __construct(MailerInterface $mailer, UrlGeneratorInterface $url)
    {
        $this->mailer = $mailer;
        $this->url = $url;
    }


    public function contactEmail(string $from, string $subject, string $twigTemplate, $message, $nom, $prenom)
    {
        try {
            $email = (new TemplatedEmail())
            ->from($from)
            ->to(new Address('thedistrict@gmail.fr'))
            ->subject($subject)
            ->htmlTemplate($twigTemplate)
            ->locale('fr')
            ->context([
                'nom' => $nom,
                'prenom' => $prenom,
                'message' => $message,
            ]);
    
            $this->mailer->send($email);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l envoie de l email : " . $e->getMessage());
            
        }

    }

    public function registerEmail(string $to, string $subject, string $twigTemplate, $nom, $prenom)
    {

        $url = $this->url->generate('app_confirm_email', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new TemplatedEmail())
        ->from('thedistrict@gmail.fr')
        ->to($to)
        ->subject($subject)
        ->htmlTemplate($twigTemplate)
        ->locale('fr')
        ->context([
            'nom' => $nom,
            'prenom' => $prenom,
            'expiration_date' => new \DateTime('+7 days'),
            'urlvalidation' => $url
        ]);

        $this->mailer->send($email);

    }






}