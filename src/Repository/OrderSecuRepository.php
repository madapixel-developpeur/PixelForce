<?php

namespace App\Repository;

use App\Entity\OrderSecu;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderSecu>
 *
 * @method OrderSecu|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderSecu|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderSecu[]    findAll()
 * @method OrderSecu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderSecuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderSecu::class);
    }

    public function add(OrderSecu $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderSecu $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
//     * @return OrderSecu[] Returns an array of OrderSecu objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?OrderSecu
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function getCAMensuel(array $agentIds, DateTime $start, DateTime $end, $secteurId)
    {
        $result = $this->createQueryBuilder('o')
            ->select(
                'COALESCE(
                SUM(
                    o.amountHt
                )
            , 0) as totalAmount',
            )
            ->andWhere('o.statut = :orderStatusPaid')
            ->andWhere('o.secteur = :secteurId')
            ->andWhere('o.agent IN (:agentIds)')
            ->andWhere('o.createdAt >= :start')
            ->andWhere('o.createdAt <= :end')
            ->setParameter('orderStatusPaid', OrderSecu::PAIED)
            ->setParameter('secteurId', $secteurId)
            ->setParameter('agentIds', $agentIds)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getSingleScalarResult();
        return round($result, 2);
    }

    public function getActifPartenaire(array $agentIds, $secteurId)
    {
        $result = $this->createQueryBuilder('o')
            ->join('o.agent', 'a')
            ->select('count(DISTINCT a.id)')
            ->andWhere('o.statut = :orderStatusPaid')
            ->andWhere('o.secteur = :secteurId')
            ->andWhere('a.id IN (:agentIds)')
            ->setParameter('orderStatusPaid', OrderSecu::PAIED)
            ->setParameter('secteurId', $secteurId)
            ->setParameter('agentIds', $agentIds)
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    public function getCurrentStat($agentID, DateTime $dateRef, $secteurId)
    {
        $qb = $this->createQueryBuilder('o')
            ->select(
                'COALESCE(SUM(CASE WHEN YEAR(o.dateCommande) = YEAR(:now) THEN o.amount ELSE 0 END), 0) AS total_year',
                'COALESCE(SUM(CASE WHEN YEAR(o.dateCommande) = YEAR(:now) AND MONTH(o.dateCommande) = MONTH(:now) THEN o.amount ELSE 0 END), 0) AS total_month',
            )
            ->andWhere('o.statut = :orderStatusPaid')
            ->andWhere('a.agent = :agentId')
            ->andWhere('o.secteur = :secteurId')
            ->setParameter('orderStatusPaid', OrderSecu::PAIED)
            ->setParameter('secteurId', $secteurId)
            ->setParameter('agentId', $agentID)
            ->setParameter('now', $dateRef)
        ;
        return $qb->getQuery()->getSingleResult();
    }
}
