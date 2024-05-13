<?php

namespace App\Repository;

use App\Entity\MetalStyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MetalStyle>
 *
 * @method MetalStyle|null find($id, $lockMode = null, $lockVersion = null)
 * @method MetalStyle|null findOneBy(array $criteria, array $orderBy = null)
 * @method MetalStyle[]    findAll()
 * @method MetalStyle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetalStyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MetalStyle::class);
    }

//    /**
//     * @return MetalStyle[] Returns an array of MetalStyle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MetalStyle
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
