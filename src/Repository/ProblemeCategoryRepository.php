<?php

namespace App\Repository;

use App\Entity\ProblemeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProblemCategory>
 *
 * @method ProblemCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProblemCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProblemCategory[]    findAll()
 * @method ProblemCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProblemeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProblemeCategory::class);
    }

//    /**
//     * @return ProblemCategory[] Returns an array of ProblemCategory objects
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

//    public function findOneBySomeField($value): ?ProblemCategory
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
