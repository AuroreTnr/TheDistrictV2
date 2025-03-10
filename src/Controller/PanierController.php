<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PanierController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/index.html.twig', [
            'panier' => $panier->getPanier(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Panier $panier, PlatRepository $platRepository): Response
    {
        $plat = $platRepository->findOneById($id);

        $panier->add($plat);

        $this->addFlash('success', 'Ajouter au panier');


        return $this->redirectToRoute('app_plats');
    }
}
