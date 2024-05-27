<?php

namespace App\Repository;

use App\Entity\FormationQuizItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormationQuizItem>
 *
 * @method FormationQuizItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationQuizItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationQuizItem[]    findAll()
 * @method FormationQuizItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationQuizItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationQuizItem::class);
    }

    public function add(FormationQuizItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FormationQuizItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FormationQuizItem[] Returns an array of FormationQuizItem objects
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

//    public function findOneBySomeField($value): ?FormationQuizItem
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
