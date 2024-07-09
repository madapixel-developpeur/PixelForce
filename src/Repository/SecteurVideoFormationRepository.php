<?php

namespace App\Repository;

use App\Entity\SecteurVideoFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SecteurVideoFormation>
 *
 * @method SecteurVideoFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecteurVideoFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecteurVideoFormation[]    findAll()
 * @method SecteurVideoFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecteurVideoFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecteurVideoFormation::class);
    }

//    /**
//     * @return SecteurVideoFormation[] Returns an array of SecteurVideoFormation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SecteurVideoFormation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
