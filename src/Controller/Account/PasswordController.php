<?php

namespace App\Controller\Account;

use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


class PasswordController extends AbstractController
{
    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;    
    }

    #[Route('compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordhasher' => $userPasswordHasherInterface,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManagerInterface->flush();

            $this->addFlash('success', 'Votre mot de passe à bien été modifié');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/password/index.html.twig', [
            'passwordform' => $form->createView(),
        ]);
    }




}