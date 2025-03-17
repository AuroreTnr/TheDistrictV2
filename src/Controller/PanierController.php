<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PanierController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/index.html.twig', [
            'panier' => $panier->getPanier(),
            'totalWt' => $panier->getNetTotalWt(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Panier $panier, PlatRepository $platRepository, Request $request): Response
    {
        $plat = $platRepository->findOneById($id);

        $panier->add($plat);

        $this->addFlash('success', 'Ajouter au panier');


        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Panier $panier): Response
    {
        $panier->remove();


        return $this->redirectToRoute('app_home');
    }

    #[Route('/cart/less/{id}', name: 'app_cart_less')]
    public function less(Panier $panier, $id): Response
    {
        $panier->less($id);

        $this->addFlash('success', 'Article retirer du panier');


        return $this->redirectToRoute('app_panier');
    }
}
