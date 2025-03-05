<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class MailerController extends AbstractController
{




    public function sendEmail(string $from, string $to, string $subject, string $text, string $html): Email
    {
        $email = (new Email())
        ->from($from)
        ->to($to)
        ->subject($subject)
        ->text($text)
        ->html('<p>' . $html . '</p>');

        return $email;

    }
}