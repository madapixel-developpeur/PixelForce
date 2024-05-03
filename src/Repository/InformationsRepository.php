<?php

namespace App\Repository;

use App\Entity\Informations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Informations>
 *
 * @method Informations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Informations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Informations[]    findAll()
 * @method Informations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Informations::class);
    }

//    /**
//     * @return Informations[] Returns an array of Informations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Informations
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
