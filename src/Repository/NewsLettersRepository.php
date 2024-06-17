<?php

namespace App\Repository;

use App\Entity\NewsLetters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsLetters>
 *
 * @method NewsLetters|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsLetters|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsLetters[]    findAll()
 * @method NewsLetters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsLettersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsLetters::class);
    }

//    /**
//     * @return NewsLetters[] Returns an array of NewsLetters objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NewsLetters
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
