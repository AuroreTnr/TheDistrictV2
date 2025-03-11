<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\CategorieRepository;
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


    #[Route('/plats/{page?1}', name: 'app_plats')]
    public function showPlats(Request $request, PlatRepository $platRepository, $page): Response
    {
        $nbre_total_plat = $platRepository->count();

        $nbre_de_plat_par_page = 6;

        $plats = $platRepository->findBy([],[], $nbre_de_plat_par_page, ($page - 1) * $nbre_de_plat_par_page);

        $nbre_de_page = ceil($nbre_total_plat / $nbre_de_plat_par_page);

        return $this->render('catalogue/plats.html.twig', [
            'plats' => $plats,
            'isPaginated' => true,
            'nbre_de_page' => $nbre_de_page,
            'page' => $page
        ]);
    }

    #[Route('/categorie/{page?1}', name: 'app_categorie')]
    public function showCategorie(Request $request, CategorieRepository $categorieRepository, $page): Response
    {
        $nbre_total_plat = $categorieRepository->count();

        $nbre_de_plat_par_page = 4;

        $categories = $categorieRepository->findBy([],[], $nbre_de_plat_par_page, ($page - 1) * $nbre_de_plat_par_page);

        $nbre_de_page = ceil($nbre_total_plat / $nbre_de_plat_par_page);

        return $this->render('catalogue/categorie.html.twig', [
            'categories' => $categories,
            'isPaginated' => true,
            'nbre_de_page' => $nbre_de_page,
            'page' => $page
        ]);
    }
}
