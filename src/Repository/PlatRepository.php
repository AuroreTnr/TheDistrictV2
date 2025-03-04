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
    public const PLAT_PAR_PAGE = 6;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plat::class);
    }

    public function getPlatPaginator(int $offset): Paginator
{
    $query = $this->createQueryBuilder('p')
        ->orderBy('p.id', 'ASC')
        ->setMaxResults(self::PLAT_PAR_PAGE)
        ->setFirstResult($offset)
        ->getQuery()
    ;

    return new Paginator($query);
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
