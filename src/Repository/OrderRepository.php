<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\SearchEntity\OrderSearch;
use App\Entity\Secteur;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Permet de filtrer les ventes
     *
     * @param OrderSearch $search
     */
    public function findOrdersQuery(OrderSearch $search)
    {
        $query = $this->createQueryBuilder('o');

        if ($search->getSecteur()) {
            $query = $query
                    ->join('o.secteur', 's')
                    ->andwhere('s.nom LIKE :nomSecteur')
                    ->setParameter('nomSecteur', '%'.$search->getSecteur()->getNom().'%');
        }

        return $query->getQuery()
            ->getResult()
        ;
    }
    /**
     * Permet de filtrer les ventes
     *
     * @param OrderSearch $search
     */
    public function findOrdersInListOfSecteurQuery($coachSecteurs)
    {
        $query = $this->createQueryBuilder('o');

        $query = $query
                    ->join('o.secteur', 's');
                    
        for($i=0;$i<count($coachSecteurs);$i++){
            $paramName = "s".$i;
            $query = $query
                ->orWhere('s.nom LIKE :'.$paramName)
                ->setParameter($paramName, '%'.$coachSecteurs[$i]->getSecteur()->getNom().'%');
        }

        return $query->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Order[] Returns an array of Order objects
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

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
