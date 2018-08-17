<?php

namespace App\Repository;

use App\Entity\ShipOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ShipOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShipOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShipOrder[]    findAll()
 * @method ShipOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShipOrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShipOrder::class);
    }

//    /**
//     * @return ShipOrder[] Returns an array of ShipOrder objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShipOrder
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
