<?php

namespace App\Repository;

use DateTime;
use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\RankHistory;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<RankHistory>
 *
 * @method RankHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RankHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RankHistory[]    findAll()
 * @method RankHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RankHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RankHistory::class);
    }

    public function getUserCurrentRank(User $user,DateTime $dateRef,Secteur $secteur){
        return $this->createQueryBuilder('r')
            ->andWhere('r.secteur = :secteur')
            ->andWhere('r.user = :user')
            ->andWhere('DATE(r.createdAt) = :date_ref')
            ->setParameter('secteur', $secteur)
            ->setParameter('user', $user)
            ->setParameter('date_ref', $dateRef->format('Y-m-d'))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return RankHistory[] Returns an array of RankHistory objects
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

//    public function findOneBySomeField($value): ?RankHistory
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
