<?php

namespace App\Repository;

use App\Entity\FormationTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormationTheme>
 *
 * @method FormationTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationTheme[]    findAll()
 * @method FormationTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationTheme::class);
    }

//    /**
//     * @return FormationTheme[] Returns an array of FormationTheme objects
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

//    public function findOneBySomeField($value): ?FormationTheme
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
