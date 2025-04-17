<?php

namespace App\Repository;

use App\Entity\OrderSecuLineV2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderSecuLineV2>
 *
 * @method OrderSecuLineV2|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderSecuLineV2|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderSecuLineV2[]    findAll()
 * @method OrderSecuLineV2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderSecuLineV2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderSecuLineV2::class);
    }

    public function add(OrderSecuLineV2 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderSecuLineV2 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OrderSecuLineV2[] Returns an array of OrderSecuLineV2 objects
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

//    public function findOneBySomeField($value): ?OrderSecuLineV2
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
