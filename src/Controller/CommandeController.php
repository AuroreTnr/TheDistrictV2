<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Classe\SetEmail;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Form\CommandeType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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
    public function add(Request $request, Panier $panier, EntityManagerInterface $entityManagerInterface): Response
    {

        $plats = $panier->getPanier();

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


            // creation de la chaine adresse
            $adresseObjet = $form->get('adresses')->getData();

            $adresse = $adresseObjet->getPrenom() . ' ' . $adresseObjet->getNom() . "<br>";
            $adresse .= $adresseObjet->getAdresse() . "<br>";
            $adresse .= $adresseObjet->getPostal() . $adresseObjet->getVille() . "<br>";
            $adresse .= $adresseObjet->getPays() . "<br>";
            $adresse .= $adresseObjet->getPhone() . "<br>";

            // creation commande
            $commande = new Commande();
            $commande->setUser($this->getUser());
            $commande->setDateCommande(new \DateTime());
            $commande->setStatus(1);
            $commande->setNomTransporteur($form->get('transporteur')->getData()->getNom());
            $commande->setPrixTransporteur($form->get('transporteur')->getData()->getPrix());
            $commande->setAdresseLivraison($adresse);

            // details commande
            foreach ($plats as $plat) {
                $detailCommande = new DetailCommande();
                $detailCommande->setNomPlat($plat['object']->getLibelle());
                $detailCommande->setIllustrationPlat($plat['object']->getImage());
                $detailCommande->setPrixPlat($plat['object']->getPrix());
                $detailCommande->setTvaPlat($plat['object']->getTva());
                $detailCommande->setQuantitePlat($plat['qty']);
                // insertion des detail commande dans la commande î
                $commande->addDetailCommande($detailCommande);
            }

            // inserer les données
            $entityManagerInterface->persist($commande);
            $entityManagerInterface->flush();

        }


        return $this->render('commande/sommaire.index.html.twig', [
            'choix' => $form->getData(),
            'panier' => $plats,
            'totalWt' => $panier->getNetTotalWt(),
            'commande' => $commande
        ]);
    }
}
