<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Adresse;
use App\Form\AdresseUserType;
use App\Form\PasswordUserType;
use App\Repository\AdresseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{

    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;    
    }



    #[Route('/compte', name: 'app_account')]
    public function index(Panier $panier): Response
    {
        return $this->render('account/index.html.twig', [
            'panier' => $panier->getPanier(),
        ]);
    }

    #[Route('compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function modifierMotDePasse(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
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

        return $this->render('account/password.html.twig', [
            'passwordform' => $form->createView(),
        ]);
    }

    #[Route('/compte/adresses', name: 'app_account_adresses')]
    public function adresses(Panier $panier): Response
    {
        return $this->render('account/adresses.html.twig', [
            'panier' => $panier->getPanier(),
        ]);
    }

    #[Route('/compte/adresse/delete/{id}', name: 'app_account_adresse_delete')]
    public function adresseDelete(Panier $panier, $id, AdresseRepository $adresseRepository): Response
    {
        $adresse = $adresseRepository->findOneById($id);
        if (!$adresse OR $adresse->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_adresses');
        }

        $this->entityManagerInterface->remove($adresse);
        $this->entityManagerInterface->flush();

        $this->addFlash('success', "Votre adresse est correctement sauvegardée");

        return $this->redirectToRoute('app_account_adresses');

    }



    #[Route('/compte/adresse/ajouter/{id}', name: 'app_account_adresse_form', defaults: ['id' => null])]
    public function adresseForm(Request $request, Panier $panier, $id, AdresseRepository $adresseRepository): Response
    {
        if ($id) {
            $adresse = $adresseRepository->findOneById($id);
            if (!$adresse OR $adresse->getUser() != $this->getUser()) {
                return $this->redirectToRoute('app_account_adresses');
            }
        } else {
            $adresse = new Adresse;
            $adresse->setUser($this->getUser());
        }

        $form = $this->createForm(AdresseUserType::class, $adresse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManagerInterface->persist($adresse);
            $this->entityManagerInterface->flush();

            $this->addFlash('success', "Votre adresse est correctement sauvegardée");

            return $this->redirectToRoute('app_account_adresses');


        }


        return $this->render('account/adresseForm.html.twig', [
            'panier' => $panier->getPanier(),
            'adresseForm' => $form
        ]);
    }
}
