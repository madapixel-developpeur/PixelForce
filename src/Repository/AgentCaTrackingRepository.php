<?php

namespace App\Repository;

use App\Util\Search\Constants;
use App\Entity\AgentCaTracking;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AgentCaTracking>
 *
 * @method AgentCaTracking|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgentCaTracking|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgentCaTracking[]    findAll()
 * @method AgentCaTracking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentCaTrackingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgentCaTracking::class);
    }

    public function add(AgentCaTracking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AgentCaTracking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getRankingAgentByCa(){
        return $this->createQueryBuilder('a')
            ->select('a.amount as total_ca','a.details','u.username','u.nom','u.prenom','u.id')
            ->join('a.agent','u')
            ->orderBy('a.amount', 'DESC')
            ->setMaxResults(Constants::NUMBER_OF_USER_TO_SHOW)
            ->getQuery()
            ->getResult()
       ;
    }

//    /**
//     * @return AgentCaTracking[] Returns an array of AgentCaTracking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AgentCaTracking
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
