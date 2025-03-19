<?php

namespace App\Controller\Account;

use App\Classe\Panier;
use App\Entity\Adresse;
use App\Form\AdresseUserType;
use App\Repository\AdresseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class AdresseController extends AbstractController
{
    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;    
    }

    
    #[Route('/compte/adresses', name: 'app_account_adresses')]
    public function index(Panier $panier): Response
    {
        return $this->render('account/adresse/index.html.twig', [
            'panier' => $panier->getPanier(),
        ]);
    }

    #[Route('/compte/adresse/delete/{id}', name: 'app_account_adresse_delete')]
    public function delete(Panier $panier, $id, AdresseRepository $adresseRepository): Response
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
    public function form(Request $request, Panier $panier, $id, AdresseRepository $adresseRepository): Response
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


        return $this->render('account/adresse/form.html.twig', [
            'panier' => $panier->getPanier(),
            'adresseForm' => $form
        ]);
    }


}