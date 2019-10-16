<?php

namespace App\Repository;

use App\Entity\LikedShops;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LikedShops|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikedShops|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikedShops[]    findAll()
 * @method LikedShops[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikedShopsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LikedShops::class);
    }

    // /**
    //  * @return LikedShops[] Returns an array of LikedShops objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LikedShops
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
