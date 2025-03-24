<?php

namespace App\Controller;

use App\Classe\Pagination;
use App\Entity\Categorie;
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

    private $pagination;

    public function __construct(Pagination $pagination, EntityManagerInterface $entityManagerInterface)
    {
        $this->pagination = $pagination;
    }




    #[Route('/', name: 'app_home')]
    public function index(PlatRepository $platRepository, CategorieRepository $categorieRepository): Response
    {

        $platsPopulaire = $platRepository->get_populaire_plat();
        $categoriesPopulaire = $categorieRepository->get_populaire_categorie();

        return $this->render('catalogue/index.html.twig', [
            'platsPopulaire' => $platsPopulaire,
            'categoriesPopulaire' => $categoriesPopulaire,
        ]);
    }


    #[Route('/plats/{page?1}', name: 'app_plats')]
    public function showPlats(Request $request, $page): Response
    {
        $result = $this->pagination->setPagination(Plat::class, 6, $page);

        return $this->render('catalogue/plats.html.twig', [
            'plats' => $result['objets'],
            'isPaginated' => $result['isPaginated'],
            'nbre_de_page' => $result['nbre_de_page'],
            'page' => $result['page']
        ]);
    }

    #[Route('/categorie/{page?1}', name: 'app_categorie')]
    public function showCategorie(Request $request, $page): Response
    {
        $result = $this->pagination->setPagination(Categorie::class, 4, $page);

        return $this->render('catalogue/categorie.html.twig', [
            'categories' => $result['objets'],
            'isPaginated' => $result['isPaginated'],
            'nbre_de_page' => $result['nbre_de_page'],
            'page' => $result['page']
        ]);
    }

}
