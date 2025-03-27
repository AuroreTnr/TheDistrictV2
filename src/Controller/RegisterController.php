<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\ContactUserType;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{

    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $user = new User;

        $form = $this->createForm(RegisterUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setRoles(["ROLE_CLIENT"]);

            $user = $form->getData();

            try {

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            $this->addFlash('success','Votre inscription est bien validée !');

            // Envoie un email de confirmation
            
            $mail = new Mail();
            $variables = [
                'prenom' => $user->getPrenom(),
            ];
        
            $mail->send($user->getEmail(), $user->getPrenom() . ' ' . $user->getNom(),"Bienvenue sur le restaurant the District ", "welcome.html", $variables);
    
    
    
            return $this->redirectToRoute('app_login');

            } catch (Exception $e) {
                throw new Exception("Erreur lors de l envoie de l email : " . $e->getMessage());
            }



            return $this->redirectToRoute('app_login');

        }

        return $this->render('register/index.html.twig', [
            'registerform' => $form->createView(),
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        
        $form = $this->createForm(ContactUserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_nom = $form->getData()['nom'];
            $user_prenom = $form->getData()['prenom'];
            $user_email = $form->getData()['email'];
            $user_message = $form->getData()['message'];
    
            try {

                $mail = new Mail();
                $variables = [
                    'prenom' => $user_prenom,
                    'nom' => $user_nom,
                    'email' => $user_email,
                    'message' => $user_message,
                ];
            
                $mail->send('thedistrict@yopmail.com', 'service SAV',"Contact client", "contact.html", $variables);

                
                $this->addFlash('success','Votre email a bien été envoyé !');
                
                return $this->redirectToRoute('app_home');

            } catch (Exception $e) {
                throw new Exception("Erreur lors de l envoie de l email : " . $e->getMessage());
            }

        }

        
        return $this->render('contact/index.html.twig', [
            'contactform' => $form->createView()
        ]);
    }


    #[Route('/confirmation-email', name: 'app_confirm_email')]
    public function showConfirmationEmail(Request $request): Response
    {


        return $this->render('emails/confirmation.html.twig');
    }

}
