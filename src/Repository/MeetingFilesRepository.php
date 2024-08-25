<?php

namespace App\Repository;

use App\Entity\MeetingFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MeetingFiles>
 *
 * @method MeetingFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetingFiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetingFiles[]    findAll()
 * @method MeetingFiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetingFiles::class);
    }

//    /**
//     * @return MeetingFiles[] Returns an array of MeetingFiles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MeetingFiles
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
