<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            // permet de mettre dans notre case option du formulaire les adresses DE l utilisateur.
            'adresses' => $adresses,
            // permet de passer les information vers une autre route ici app_commande_sommaire
            'action' => $this->generateUrl('app_commande_sommaire')
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
    public function add(Request $request, Panier $panier): Response
    {

        if ($request->getMethod() != 'POST') {
            return $this->redirectToRoute('app_panier');
        }


        $form = $this->createForm(CommandeType::class, null, [
            // permet de mettre dans notre case option du formulaire les adresses DE l utilisateur.
            'adresses' => $this->getUser()->getAdresses(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // stoker les informations
        }


        return $this->render('commande/sommaire.index.html.twig', [
            'choix' => $form->getData(),
            'panier' => $panier->getPanier(),
            'totalWt' => $panier->getNetTotalWt(),
        ]);
    }
}
