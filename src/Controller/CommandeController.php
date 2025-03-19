<?php

namespace App\Controller;

use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CommandeController extends AbstractController
{
    /**
     * 
     * premiere etape du tunel d achat :
     * choix de l adresse de livraison et du transporteur
     */
    #[Route('/commande/livraison', name: 'app_commande')]
    public function index(): Response
    {

        $adresses = $this->getUser()->getAdresses();

        if (count($adresses) == 0) {
            return $this->redirectToRoute('app_account_adresse_form');
        }

        $form = $this->createForm(CommandeType::class, null, [
            // permet de mettre dans notre case option du formulaire les adresses de l utilisateur.
            'adresses' => $adresses,
        ]);


        return $this->render('commande/index.html.twig', [
            'adresseForm' => $form->createView(),
        ]);
    }



    /**
     * 
     * deuxieme etape du tunel d achat :
     * recap de la commande de l utilisateur
     * insertion en base de donnée
     * preparation du paiement vers stripe
     */
    #[Route('/commande/recapitulatif', name: 'app_commande_sommaire')]
    public function add(): Response
    {




        return $this->render('commande/sommaire.index.html.twig');
    }
}
