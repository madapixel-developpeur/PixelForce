<?php

namespace App\Repository;

use App\Entity\UserTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserTransaction>
 *
 * @method UserTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTransaction[]    findAll()
 * @method UserTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTransaction::class);
    }

    public function save(UserTransaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserTransaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSolde($user, $secteurIds)
   {
       $qb = $this->createQueryBuilder('u')
       ->select('coalesce(sum(u.amount * (CASE WHEN u.sortie = 1 THEN -1 ELSE 1 END)), 0) as solde')
       ->leftJoin('u.secteur', 's')
       ->andWhere('u.status = :statusValid')
       ->setParameter('statusValid', UserTransaction::STATUS_VALID)
           ->andWhere('u.user = :user')
           ->setParameter('user', $user);

    if ($secteurIds) {
        $qb->andWhere('s.id in (:secteurIds)')
        ->setParameter('secteurIds', $secteurIds);
    }
           
        $result =   $qb->getQuery()
           ->getScalarResult()
       ;
       return count($result) > 0 ? floatval($result[0]['solde']) : 0;
   }

//    /**
//     * @return UserTransaction[] Returns an array of UserTransaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserTransaction
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
