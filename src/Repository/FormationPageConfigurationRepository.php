<?php

namespace App\Repository;

use App\Entity\FormationPageConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormationPageConfiguration>
 *
 * @method FormationPageConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationPageConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationPageConfiguration[]    findAll()
 * @method FormationPageConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationPageConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationPageConfiguration::class);
    }

//    /**
//     * @return FormationPageConfiguration[] Returns an array of FormationPageConfiguration objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FormationPageConfiguration
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
