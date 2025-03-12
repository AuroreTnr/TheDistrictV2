<?php

namespace App\Classe;

use Doctrine\ORM\EntityManagerInterface;

class Pagination
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    public function setPagination($classRepository, $nbre_objet_par_page, $page)
    {

        $repository = $this->entityManager->getRepository($classRepository);

        $nbre_total_objet = $repository->count();

        $nbre_de_page = ceil($nbre_total_objet / $nbre_objet_par_page);
        
        $page = max(1, min($page, $nbre_de_page));

        $objets = $repository->findBy([],[], $nbre_objet_par_page, ($page - 1) * $nbre_objet_par_page);


        return [
            'objets' => $objets,
            'isPaginated' => true,
            'nbre_de_page' => $nbre_de_page,
            'page' => $page
        ];

    }


}