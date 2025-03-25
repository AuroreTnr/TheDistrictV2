<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FactureController extends AbstractController
{
    /**
     * 
     * impression facture pdf pour un utilisateur connecté
     * vérification de la commande pour un utilisateur donné
     * 
     */
    #[Route('/compte/facture/impression/{id_commande}', name: 'app_facture_client')]
    public function FacturePourClient(CommandeRepository $commandeRepository, $id_commande): Response
    {
        $commande = $commandeRepository->findOneById($id_commande);
        
        if (!$commande) {
            return $this->redirectToRoute('app_account');
        }

        if ($commande->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account');
        }

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $html = $this->renderView('facture/index.html.twig', [
            'commande' => $commande
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('facture.pdf', [
            'Attachment' => false
        ]);

        exit();

        // return $this->render('facture/index.html.twig', [
        //     'controller_name' => 'FactureController',
        // ]);
    }


        /**
     * 
     * impression facture pdf pour un administrateur
     * 
     */

    #[Route('/compte/facture/impression/{id_commande}', name: 'app_facture_admin')]
    public function FacturePourAdmin(CommandeRepository $commandeRepository, $id_commande): Response
    {
        $commande = $commandeRepository->findOneById($id_commande);
        
        if (!$commande) {
            return $this->redirectToRoute('admin');
        }


        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $html = $this->renderView('facture/index.html.twig', [
            'commande' => $commande
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('facture.pdf', [
            'Attachment' => false
        ]);

        exit();

        // return $this->render('facture/index.html.twig', [
        //     'controller_name' => 'FactureController',
        // ]);
    }
}
