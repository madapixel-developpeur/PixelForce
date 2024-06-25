<?php

namespace App\Repository;

use App\Entity\FormationQuizItemChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormationQuizItemChoice>
 *
 * @method FormationQuizItemChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationQuizItemChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationQuizItemChoice[]    findAll()
 * @method FormationQuizItemChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationQuizItemChoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationQuizItemChoice::class);
    }

    public function add(FormationQuizItemChoice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FormationQuizItemChoice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FormationQuizItemChoice[] Returns an array of FormationQuizItemChoice objects
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

//    public function findOneBySomeField($value): ?FormationQuizItemChoice
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
