<?php

namespace App\Repository;

use App\Entity\PackCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PackCategory>
 *
 * @method PackCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackCategory[]    findAll()
 * @method PackCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackCategory::class);
    }

    public function add(PackCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PackCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSearchQuery($category){
        $qb = $this->createQueryBuilder('c');
        $parameters = [];
        if($category->getNom()!=null) {
            $qb->andWhere('LOWER(c.name) LIKE LOWER(:name)');
            $parameters['name'] = '%'.$category->getName(). '%';
        }
        if($category->getDescription()!=null) {
            $qb->andWhere('LOWER(c.description) LIKE LOWER(:description)');
            $parameters['description'] = '%'.$category->getDescription(). '%';
        }

        $qb->setParameters($parameters);
        return $qb->getQuery();

    }

    public function getFindAllQuery(){
        return $this->createQueryBuilder('c')->getQuery();
    }

    public function findAllActivePackCategory(){
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.status = 1');
        return $qb->getQuery()->execute();
    }

//    /**
//     * @return PackCategory[] Returns an array of PackCategory objects
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

//    public function findOneBySomeField($value): ?PackCategory
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
