<?php

namespace App\Controller;

use App\Form\ContactUserType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer, MailerController $send_email): Response
    {
        $form = $this->createForm(ContactUserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_name = $form->getData()['nom'];
            $user_prenom = $form->getData()['prenom'];
            $user_email = $form->getData()['email'];
            $user_message = $form->getData()['message'];
    
            $email = $send_email->sendEmail($user_email, 'thedistrict@mail.fr', 'Contact client', $user_name . '' . $user_prenom, $user_message);

            if (!$email) {
                throw new Exception("Une erreur s' est produite", 1);
                
            }

            $mailer->send($email);

            $this->addFlash('success','Votre email a bien été envoyé !');
    
        }

        


        return $this->render('contact/index.html.twig', [
            'contactform' => $form->createView()
        ]);
    }
}
