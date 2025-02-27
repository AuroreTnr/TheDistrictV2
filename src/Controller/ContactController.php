<?php

namespace App\Controller;

use App\Form\ContactUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactUserType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }


        return $this->render('contact/index.html.twig', [
            'contactform' => $form->createView()
        ]);
    }
}
