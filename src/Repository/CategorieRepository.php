<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }


    /**
 * donne les categories populaire avec une limite à 6
 * @param mixed $db
 * @return mixed
 */
function get_populaire_categorie() {
    $connection = $this->getEntityManager()->getConnection();

    $sql = '
    SELECT 
        categorie.libelle, 
        categorie.id,
        categorie.image, 
        categorie.slug, 
        SUM(detail_commande.quantite_plat) AS total_quantite
    FROM detail_commande
    JOIN plat ON detail_commande.nom_plat = plat.libelle
    JOIN categorie ON plat.categorie_id = categorie.id
    GROUP BY categorie.id
    ORDER BY total_quantite DESC
    LIMIT 6    ';

    $resultSet = $connection->executeQuery($sql);

    return $resultSet->fetchAllAssociative();
}



    //    /**
    //     * @return Categorie[] Returns an array of Categorie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Categorie
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
