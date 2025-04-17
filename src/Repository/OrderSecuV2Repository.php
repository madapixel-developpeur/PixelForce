<?php

namespace App\Repository;

use App\Entity\OrderSecuV2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderSecuV2>
 *
 * @method OrderSecuV2|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderSecuV2|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderSecuV2[]    findAll()
 * @method OrderSecuV2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderSecuV2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderSecuV2::class);
    }

    public function add(OrderSecuV2 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderSecuV2 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OrderSecuV2[] Returns an array of OrderSecuV2 objects
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

//    public function findOneBySomeField($value): ?OrderSecuV2
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
