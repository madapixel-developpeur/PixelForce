<?php

namespace App\Repository;

use App\Entity\RemunerationHistorySecu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RemunerationHistorySecu>
 *
 * @method RemunerationHistorySecu|null find($id, $lockMode = null, $lockVersion = null)
 * @method RemunerationHistorySecu|null findOneBy(array $criteria, array $orderBy = null)
 * @method RemunerationHistorySecu[]    findAll()
 * @method RemunerationHistorySecu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemunerationHistorySecuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RemunerationHistorySecu::class);
    }

    public function add(RemunerationHistorySecu $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RemunerationHistorySecu $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
//     * @return RemunerationHistorySecu[] Returns an array of RemunerationHistorySecu objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?RemunerationHistorySecu
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
