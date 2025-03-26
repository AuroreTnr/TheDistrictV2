<?php

namespace App\Controller\Account;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CommandeController extends AbstractController
{
    #[Route('/compte/commande/{id_commande}', name: 'app_account_commande')]
    public function index($id_commande, CommandeRepository $commandeRepository): Response
    {

        $commande = $commandeRepository->findOneBy([
            'id' => $id_commande,
            'user' => $this->getUser()
        ]);

        if (!$commande) {
            return $this->redirectToRoute('app_home');
        }


        return $this->render('account/commande/index.html.twig', [
            'commandes' => $commande,
        ]);
    }
}
