<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;

// require_once'../secrets.php';

final class PaiementController extends AbstractController
{
    #[Route('/commande/paiement/{id_commande}', name: 'app_paiement')]
    public function index($id_commande, CommandeRepository $commandeRepository): Response
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
            'success_url' => $_ENV['DOMAINE']. '/success.html',
            'cancel_url' => $_ENV['DOMAINE']. '/cancel.html',
          ]);


            return $this->redirect($checkout_session->url);
    }
}
