<?php

namespace App\Repository;

use App\Entity\CategorieFormation;
use App\Entity\SearchEntity\CategorieFormationSearch;
use App\Util\Search\Constants;
use App\Util\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieFormation>
 *
 * @method CategorieFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieFormation[]    findAll()
 * @method CategorieFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieFormation::class);
    }

    public function add(CategorieFormation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategorieFormation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findCategorieFormationQuery(CategorieFormationSearch $search)
    {
        $query = $this->createQueryBuilder('cf');

        if (empty($_GET)) {
            $query
                ->andWhere('cf.statut=:statut')
                ->setParameter('statut', 1);
        }

        if ($search->getNom()) {
            $query = $query
                ->andwhere('cf.nom LIKE :prenom')
                ->setParameter('prenom', '%'.$search->getNom().'%');
        }
        if ($search->getDescription()) {
            $query = $query
                ->andwhere('cf.description LIKE :description')
                ->setParameter('description', '%'.$search->getDescription().'%');
        }
        if ($search->getStatut()) {
           
            $query = $query
                ->andwhere('cf.statut = :statut')
                ->setParameter('statut', $search->getStatut());
        }
        if ($search->getOrdre()) {
            $query = $query
                ->andwhere('cf.ordreCatFormation LIKE :ordre')
                ->setParameter('ordre', $search->getOrdre());
        }
       
        return $query->getQuery()
            ->getResult()
        ;
    }
    
    
    public function getNextCategory($categoryId)
    {
        $qb = $this->createQueryBuilder('cf')
            ->select('cf')
    
            ->where('cf.id > :categoryId')
            ->setParameter(':categoryId', $categoryId)
    
            ->orderBy('cf.id', 'ASC')
    
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    
        $result = $qb->getQuery()->getOneOrNullResult();
        return $result;
    }

    public function getValidCategoriesOrdered()
    {
        return $this->createQueryBuilder('cf')
            ->select('cf')
            ->andwhere('cf.statut = :statut')
            ->setParameter('statut', Status::VALID)
            ->addOrderBy('cf.ordreCatFormation','ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAccessibleFonctionnalites($rank){
        if(!$rank) return [];
        $result = $this->createQueryBuilder('cf')
        ->select('')
        ->where('cf.ordreCatFormation < :rank ')
        ->setParameter(':rank', $rank)
        ->getQuery()
        ->getResult();
        return array_reduce($result, function ($carry, $item) {
            return array_merge($carry, $item->getFonctionnalites());
        }, []);
    }

//    /**
//     * @return CategorieFormation[] Returns an array of CategorieFormation objects
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

//    public function findOneBySomeField($value): ?CategorieFormation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
