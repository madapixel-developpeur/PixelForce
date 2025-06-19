<?php

namespace App\Repository;

use App\Entity\CatalogueProductSector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CatalogueProductSector>
 *
 * @method CatalogueProductSector|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatalogueProductSector|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatalogueProductSector[]    findAll()
 * @method CatalogueProductSector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogueProductSectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatalogueProductSector::class);
    }

    public function add(CatalogueProductSector $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CatalogueProductSector $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CatalogueProductSector[] Returns an array of CatalogueProductSector objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CatalogueProductSector
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
