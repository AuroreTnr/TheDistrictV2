<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Plat>
 */
class PlatRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plat::class);
    }


    /**
 * donne les plats les plus populaire
 * @param mixed $db
 * @return mixed
 */
    public function get_populaire_plat() {
  
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT plat.*, SUM(detail_commande.quantite_plat) AS total_quantite
        FROM detail_commande
        JOIN plat ON detail_commande.nom_plat = plat.libelle
        GROUP BY plat.libelle
        ORDER BY total_quantite DESC
        LIMIT 6
        ';

        $resultSet = $connection->executeQuery($sql);

        return $resultSet->fetchAllAssociative();
}



    //    /**
    //     * @return Plat[] Returns an array of Plat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Plat
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
