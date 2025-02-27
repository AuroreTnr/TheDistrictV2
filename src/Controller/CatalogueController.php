<?php

namespace App\Controller;

use App\Entity\Plat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CatalogueController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('catalogue/index.html.twig');
    }


    #[Route('/plats', name: 'app_plats')]
    public function plats(EntityManagerInterface $entityManager): Response
    {
        $plat = $entityManager->getRepository(Plat::class)->findAll();

        if (!$plat) {
            throw $this->createNotFoundException('Aucuns plats n\' est disponible');
        }

        return $this->render('catalogue/plats.html.twig', [
            'plats' => $plat,
        ]);
    }
}
