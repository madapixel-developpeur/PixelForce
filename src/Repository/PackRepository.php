<?php

namespace App\Repository;

use App\Entity\Pack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pack>
 *
 * @method Pack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pack[]    findAll()
 * @method Pack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pack::class);
    }

    public function add(Pack $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pack $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSearchQuery($Pack, $options = null){
        $qb = $this->createQueryBuilder('p');

        $parameters = [];
        if($Pack->getName()!=null) {
            $qb->andWhere('LOWER(p.name) LIKE LOWER(:name)');
            $parameters['name'] = '%'.$Pack->getName(). '%';
        }
        if($Pack->getDescription()!=null) {
            $qb->andWhere('LOWER(p.description) LIKE LOWER(:description)');
            $parameters['description'] = '%'.$Pack->getDescription(). '%';
        }
        if($Pack->getCost()!=null) {
            $qb->andWhere('p.cost = :cost');
            $parameters['cost'] = $Pack->getCost();
        }
        if($Pack->getPackCategory()!=null) {
            $qb->andWhere('p.packCategory = :packCategory');
            $parameters['packCategory'] = $Pack->getPackCategory();
        }
        if($options != null){
            
            if($options['prixMin']!=null) {
                $qb->andWhere('p.cost >= :prixMin');
                $parameters['prixMin'] = $options['prixMin'];
            } 
            if($options['prixMax']!=null) {
                $qb->andWhere('p.cost <= :prixMax');
                $parameters['prixMax'] = $options['prixMax'];
            } 
            $withOrderOption = ($options['orderBy']!=null && $options['order']!=null);
            if($withOrderOption) {
                $qb->addOrderBy('p.'.$options['orderBy'], $options['order']);
            }
            if(!$withOrderOption){
                $qb->addOrderBy('p.name', 'asc');
            }
            
        }

        $qb->andWhere('p.packCategory is not null');
        $qb->setParameters($parameters);
        return $qb->getQuery();

    }

    public function getFindAllQuery(){
        return $this->createQueryBuilder('p')->getQuery();
    }

    public function findAllActivePack(){
        $nb_pack_per_category = 3;
        $sql = "SELECT * FROM (SELECT *, ROW_NUMBER() OVER(PARTITION BY id_pack_category ORDER BY id) as RN FROM pack) as t WHERE RN <= ".$nb_pack_per_category;
        $rsm = new \Doctrine\ORM\Query\ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata('App\Entity\Pack', 't');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $result = $query->getResult();
        return $result;
    }

//    /**
//     * @return Pack[] Returns an array of Pack objects
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

//    public function findOneBySomeField($value): ?Pack
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
