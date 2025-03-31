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



    public function setPagination($classRepository, $nbre_objet_par_page, $page, $searchQuery = '')
    {

        $repository = $this->entityManager->getRepository($classRepository);

        $queryBuilder = $repository->createQueryBuilder('p')
            ->setFirstResult(($page - 1) * $nbre_objet_par_page)
            ->setMaxResults($nbre_objet_par_page);

        if ($searchQuery) {
            $queryBuilder->andWhere('p.libelle LIKE :search')
                ->setParameter('search', '%' . $searchQuery . '%');
        }

        $query = $queryBuilder->getQuery();

        if ($searchQuery) {
            $isPagination = false;
        }else {
            $isPagination = true;
        }

        $objets = $query->getResult();

        $nbre_total_objet = $repository->createQueryBuilder('e')
        ->select('COUNT(e.id)')
        ->getQuery();

        $nbre_total_objet = $nbre_total_objet->getSingleScalarResult();


        $nbre_de_page = ceil($nbre_total_objet / $nbre_objet_par_page);
        
        $page = max(1, min($page, $nbre_de_page));
        


        return [
            'objets' => $objets,
            'isPaginated' => $isPagination,
            'nbre_de_page' => $nbre_de_page,
            'page' => $page
        ];

    }


}