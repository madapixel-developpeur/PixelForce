<?php

namespace App\Repository;

use App\Entity\CodePromoCountry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodePromoCountry>
 *
 * @method CodePromoCountry|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodePromoCountry|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodePromoCountry[]    findAll()
 * @method CodePromoCountry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodePromoCountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodePromoCountry::class);
    }

//    /**
//     * @return CodePromoCountry[] Returns an array of CodePromoCountry objects
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

//    public function findOneBySomeField($value): ?CodePromoCountry
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
