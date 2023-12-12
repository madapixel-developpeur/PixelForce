<?php

namespace App\Repository;

use App\Entity\OrderPack;
use App\Entity\SearchEntity\OrderSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderPack>
 *
 * @method OrderPack|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderPack|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderPack[]    findAll()
 * @method OrderPack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderPackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderPack::class);
    }

    public function add(OrderPack $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderPack $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
   /**
    * @return Query Returns an array of OrderPack objects
    */
   public function findByAgentQuery($value): Query
   {
       return $this->createQueryBuilder('o')
           ->andWhere('o.agent = :val')
           ->setParameter('val', $value)
           ->orderBy('o.id', 'ASC')
           ->getQuery();
   }

   /**
     * Permet de filtrer les ventes
     */
    public function findOrdersQuery()
    {
        $query = $this->createQueryBuilder('o');

        return $query->getQuery()
            ->getResult()
        ;
    }
//    /**
//     * @return OrderPack[] Returns an array of OrderPack objects
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

//    public function findOneBySomeField($value): ?OrderPack
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
