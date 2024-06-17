<?php

namespace App\Repository;

use App\Entity\PiecesJointesNewsLetters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PiecesJointesNewsLetters>
 *
 * @method PiecesJointesNewsLetters|null find($id, $lockMode = null, $lockVersion = null)
 * @method PiecesJointesNewsLetters|null findOneBy(array $criteria, array $orderBy = null)
 * @method PiecesJointesNewsLetters[]    findAll()
 * @method PiecesJointesNewsLetters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PiecesJointesNewsLettersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PiecesJointesNewsLetters::class);
    }

//    /**
//     * @return PiecesJointesNewsLetters[] Returns an array of PiecesJointesNewsLetters objects
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

//    public function findOneBySomeField($value): ?PiecesJointesNewsLetters
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
