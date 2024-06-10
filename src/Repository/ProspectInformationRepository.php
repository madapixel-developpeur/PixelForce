<?php

namespace App\Repository;

use App\Entity\ProspectInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProspectInformation>
 *
 * @method ProspectInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProspectInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProspectInformation[]    findAll()
 * @method ProspectInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProspectInformation::class);
    }

//    /**
//     * @return ProspectInformation[] Returns an array of ProspectInformation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProspectInformation
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
