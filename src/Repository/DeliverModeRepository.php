<?php

namespace App\Repository;

use App\Entity\DeliverMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeliverMode|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliverMode|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliverMode[]    findAll()
 * @method DeliverMode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliverModeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliverMode::class);
    }

    // /**
    //  * @return DeliverMode[] Returns an array of DeliverMode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeliverMode
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
