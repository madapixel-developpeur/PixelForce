<?php

namespace App\Entity;

use App\Entity\ProblemeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProblemeCategory>
 *
 * @method ProblemeCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProblemeCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProblemeCategory[]    findAll()
 * @method ProblemeCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProblemeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProblemeCategory::class);
    }

//    /**
//     * @return ProblemeCategory[] Returns an array of ProblemeCategory objects
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

//    public function findOneBySomeField($value): ?ProblemeCategory
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
