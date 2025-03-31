<?php

namespace App\Controller;

use App\Classe\Pagination;
use App\Entity\Categorie;
use App\Entity\Plat;
use App\Form\BarDeRechercheType;
use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Classe\Mail;


final class CatalogueController extends AbstractController
{

    private $pagination;

    public function __construct(Pagination $pagination, EntityManagerInterface $entityManagerInterface)
    {
        $this->pagination = $pagination;
    }


    public function createFormRecherche(Request $request){
        $createFormRecherche = $this->createForm(BarDeRechercheType::class);
        $createFormRecherche->handleRequest($request);
            
        
        return $createFormRecherche;
    }




    #[Route('/', name: 'app_home')]
    public function index(PlatRepository $platRepository, CategorieRepository $categorieRepository, Request $request): Response
    {
        $form = $this->createFormRecherche($request);
        $searchQuery = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $searchQuery = $form->get('query')->getData();
            return $this->redirectToRoute('app_plats', ['search' => $searchQuery, 'page' => 1]);
        }

        $platsPopulaire = $platRepository->get_populaire_plat();
        $categoriesPopulaire = $categorieRepository->get_populaire_categorie();

        return $this->render('catalogue/index.html.twig', [
            'platsPopulaire' => $platsPopulaire,
            'categoriesPopulaire' => $categoriesPopulaire,
            'barRecherche' => $form->createView()
        ]);
    }


    #[Route('/plats/{page?1}', name: 'app_plats')]
    public function showPlats($page, Request $request): Response
    {
        $form = $this->createFormRecherche($request);

        $searchQuery = $request->query->get('search', '');

        if ($form->isSubmitted() && $form->isValid()) {
            $searchQuery = $form->get('query')->getData();
            
            return $this->redirectToRoute('app_plats', ['search' => $searchQuery, 'page' => 1]);

        }

        $result = $this->pagination->setPagination(Plat::class, 6, $page, $searchQuery);

        return $this->render('catalogue/plats.html.twig', [
            'plats' => $result['objets'],
            'isPaginated' => $result['isPaginated'],
            'nbre_de_page' => $result['nbre_de_page'],
            'page' => $result['page'],
            'barRecherche' => $form->createView(),
            'search'=> $searchQuery
        ]);
    }

    #[Route('/categorie/{page?1}', name: 'app_categorie')]
    public function showCategorie($page, Request $request): Response
    {


        $result = $this->pagination->setPagination(Categorie::class, 4, $page);

        return $this->render('catalogue/categorie.html.twig', [
            'categories' => $result['objets'],
            'isPaginated' => $result['isPaginated'],
            'nbre_de_page' => $result['nbre_de_page'],
            'page' => $result['page'],

        ]);
    }

}
