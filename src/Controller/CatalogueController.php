<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function showplats(Request $request, PlatRepository $platRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $platRepository->getPlatPaginator($offset);

        if (!$paginator) {
            throw $this->createNotFoundException('Aucuns plats n\' est disponible');
        }

        return $this->render('catalogue/plats.html.twig', [
            'plats' => $paginator,
            'previous' => $offset - PlatRepository::PLAT_PAR_PAGE,
            'next' => min(count($paginator), $offset + PlatRepository::PLAT_PAR_PAGE),
        ]);
    }
}
