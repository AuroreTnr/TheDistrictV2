<?php

namespace App\Controller;

use App\Form\PasswordUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    #[Route('compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function modifierMotDePasse(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(PasswordUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('account/password.html.twig', [
            'passwordform' => $form->createView(),
        ]);
    }
}
