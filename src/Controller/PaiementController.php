<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;

// require_once'../secrets.php';

final class PaiementController extends AbstractController
{
    #[Route('/commande/paiement/{id_commande}', name: 'app_paiement')]
    public function index($id_commande, CommandeRepository $commandeRepository, EntityManagerInterface $entityManagerInterface): Response
    {


      Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);


      // securise la selection de la commande avec deux criteres
      $commande = $commandeRepository->findOneBy([
        'id' => $id_commande,
        'user' => $this->getUser()
      ]);

      if (!$commande) {
        return $this->redirectToRoute('app_home');
      }



      // plats
      $platPourStripe= [];
      
      foreach($commande->getDetailCommandes() as $plat){

      $platPourStripe[]= [
        'price_data' => [
          'currency' => 'eur',
          'unit_amount' => number_format($plat->getPlatPrixTTC() * 100, 0, '', ''),
          'product_data' => [
              'name' => $plat->getNomPlat(),
              'images' => [
                 $_ENV['DOMAINE'] . '/uploads/images/plat/' . $plat->getIllustrationPlat()
              ]
          ]
        ],
        'quantity' => $plat->getQuantitePlat(),

      ];
      }

      // Transporteur
      $platPourStripe[]= [
        'price_data' => [
          'currency' => 'eur',
          'unit_amount' => number_format($commande->getPrixTransporteur() * 100, 0, '', ''),
          'product_data' => [
              'name' => 'Transporteur : ' . $commande->getNomTransporteur(),
          ]
        ],
        'quantity' => 1,

      ];




        $checkout_session = Session::create([
          'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [[
              $platPourStripe
            ]],
            'mode' => 'payment',
            'success_url' => $_ENV['MJ_APIKEY_PUBLIC']. '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $_ENV['MJ_APIKEY_PRIVATE']. '/mon-panier/annulation',
          ]);

          $commande->setStripeSessionId($checkout_session->id);
          $entityManagerInterface->flush();


            return $this->redirect($checkout_session->url);
    }


    #[Route('/commande/merci/{stripe_session_id}', name: 'app_paiement_success')]
    public function success($stripe_session_id, CommandeRepository $commandeRepository, EntityManagerInterface $entityManagerInterface, Panier $panier): Response
    {
      $commande = $commandeRepository->findOneBy([
        'stripe_session_id' => $stripe_session_id,
        'user' => $this->getUser()
      ]);

      if (!$commande) {
        return $this->redirectToRoute('app_home');
      }

      if ($commande->getStatus() == 1) {
        $commande->setStatus(2);
        $panier->remove();
        $entityManagerInterface->flush();
      }

      return $this->render('paiement/success.html.twig', [
        'commande' => $commande
    ]);



    }
}
