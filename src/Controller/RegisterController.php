<?php

namespace App\Controller;

use App\Classe\SetEmail;
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

    private $setEmail;


    public function __construct(SetEmail $setEmail)
    {
        $this->setEmail = $setEmail;

    }




    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $user = new User;

        $form = $this->createForm(RegisterUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();


            $user_nom = $user->getNom();
            $user_prenom = $user->getPrenom();
            $user_email = $user->getEmail();



            try {

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            $this->addFlash('success','Votre inscription est bien validée !');

            $this->setEmail->registerEmail($user_email,'Bienvenue sur TheDisctrict ! Confirmez votre adresse email', 'emails/register.html.twig', $user_nom, $user_prenom);

            return $this->redirectToRoute('app_home');

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
                $this->setEmail->contactEmail($user_email, 'Contact client', 'emails/contact.html.twig', $user_message, $user_nom, $user_prenom);
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
