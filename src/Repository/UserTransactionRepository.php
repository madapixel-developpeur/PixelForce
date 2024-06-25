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
            ->andWhere('u.status > :statusCreated')
            ->setParameter('statusCreated', UserTransaction::STATUS_CREATED)
            ->andWhere('u.user = :user')
            ->setParameter('user', $user);

        if ($secteurIds) {
            $qb->andWhere('s.id in (:secteurIds)')
                ->setParameter('secteurIds', $secteurIds);
        }

        $result =   $qb->getQuery()
            ->getScalarResult();
        return count($result) > 0 ? floatval($result[0]['solde']) : 0;
    }

    public function getNumberOfPendingRetrait($user, $secteurIds)
    {
        $qb = $this->createQueryBuilder('u');

        $qb->select('COUNT(u.id)')
            ->leftJoin('u.secteur', 's')
            ->andWhere('u.status = :statusCreated')
            ->andWhere('u.type = :type')
            ->setParameter('statusCreated', UserTransaction::STATUS_CREATED)
            ->setParameter('type', UserTransaction::TYPE_RETRAIT)
            ->andWhere('u.user = :user')
            ->setParameter('user', $user);

        if ($secteurIds) {
            $qb->andWhere('s.id in (:secteurIds)')
                ->setParameter('secteurIds', $secteurIds);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function getHistoryQuery($user, $secteurIds, $params = null)
    {
        $qb = $this->createQueryBuilder('u');

        $qb->select('u')
            ->leftJoin('u.secteur', 's')
            ->andWhere('u.type = :type')
            ->setParameter('type', UserTransaction::TYPE_RETRAIT)
            ->andWhere('u.user = :user')
            ->setParameter('user', $user);

        if ($secteurIds) {
            $qb->andWhere('s.id in (:secteurIds)')
                ->setParameter('secteurIds', $secteurIds);
        }
        if ($params) {
            $qb->Andwhere('u.amount LIKE :keyword OR u.rib LIKE :keyword OR u.status LIKE :keyword ')
                // Ajoutez autant de champs que nécessaire pour la recherche
                ->setParameter('keyword', '%' . $params . '%');
        }
        return $qb->orderBy('u.createdAt', 'DESC');
    }

    public function getHistory($user, $secteurIds, $param = null)
    {
        $qb = $this->getHistoryQuery($user, $secteurIds, $param);
        return $qb->getQuery()->getResult();
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
