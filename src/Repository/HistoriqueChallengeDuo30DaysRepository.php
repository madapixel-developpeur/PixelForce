<?php

namespace App\Repository;

use App\Entity\HistoriqueChallengeDuo30Days;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoriqueChallengeDuo30Days>
 *
 * @method HistoriqueChallengeDuo30Days|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoriqueChallengeDuo30Days|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoriqueChallengeDuo30Days[]    findAll()
 * @method HistoriqueChallengeDuo30Days[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriqueChallengeDuo30DaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoriqueChallengeDuo30Days::class);
    }

    public function add(HistoriqueChallengeDuo30Days $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoriqueChallengeDuo30Days $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistoriqueChallengeDuo30Days[] Returns an array of HistoriqueChallengeDuo30Days objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistoriqueChallengeDuo30Days
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function getAll()
    {
        return $this->createQueryBuilder('t')
            ->getQuery();
    }
}
