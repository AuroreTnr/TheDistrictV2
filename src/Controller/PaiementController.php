<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;

// require_once'../secrets.php';

final class PaiementController extends AbstractController
{
    #[Route('/commande/paiement', name: 'app_paiement')]
    public function index(): Response
    {
        Stripe::setApiKey('sk_test_51R6YBQQAXTlnYk5dZz0KS9lpHGSsdQdYYHbUnTg9SitIxNUqKFGNzyaxOrwSnVVRxuT6k1ang09v9Ur1DUDP04lH00E0V8llgS');

        $YOUR_DOMAIN = 'http://127.0.0.1:8000';


        $checkout_session = Session::create([
            'line_items' => [[
              # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
              'price_data' => [
                'currenty' => 'eur',
                'unit_amount' => '1500',
                'product_data' => [
                    'name' => 'Produit de test'
                ]
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
          ]);

            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkout_session->url);
    }
}
