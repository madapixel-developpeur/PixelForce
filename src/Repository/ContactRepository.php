<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Entity\SearchEntity\UserSearch;
use App\Entity\User;
use DateInterval;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Contact &$entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Contact $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
     * @param UserSearch $search
     * @param string $role
     * @return Query
     */
    public function findContactQuery(UserSearch $search, $agent)
    {
        $query = $this->createQueryBuilder('c');
        $query = $query
            ->andwhere('c.agent = :agent')
            ->setParameter('agent', $agent)
            ->join('c.information', 'ci')
        ;

        if ($search->getPrenom()) {
            $query = $query
                ->andwhere('ci.lastname LIKE :lastname')
                ->orwhere('ci.firstname LIKE :lastname')
                ->setParameter('lastname', '%'.$search->getPrenom().'%');
        }
        if ($search->getEmail()) {
            $query = $query
                ->andwhere('ci.email LIKE :email')
                ->setParameter('email', '%'.$search->getEmail().'%');
        }
        if ($search->getTelephone()) {
            $query = $query
                ->andwhere('ci.phone LIKE :phone')
                ->setParameter('phone', '%'.$search->getTelephone().'%');
        }
        if ($search->getAdresse()) {
            $query = $query
                ->andwhere('ci.address LIKE :address')
                ->setParameter('address', '%'.$search->getAdresse().'%');
        }
        if ($search->getDateInscriptionMin()) {
            $query = $query
                ->andwhere('c.created_at >= :dateInscriptionMin')
                ->setParameter('dateInscriptionMin', $search->getDateInscriptionMin());
        }
        if ($search->getDateInscriptionMax()) {
            // On ajoute +1day, car la requête ne prend que la date en dessous de la date recherchée
            $search->getDateInscriptionMax()->add(new DateInterval('P1D'));

            $query = $query
                ->andwhere('c.created_at <= :dateInscriptionMax')
                ->setParameter('dateInscriptionMax', $search->getDateInscriptionMax());
        }

        return $query->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param UserSearch $search
     * @param string $role
     * @return Query
     */
    public function findContactBySecteur(UserSearch $search, $agent, $secteurId)
    {
        $query = $this->createQueryBuilder('c');
        $query = $query
            ->andwhere('c.agent = :agent')
            ->setParameter('agent', $agent)
            ->join('c.secteur', 'cs')
            ->andwhere('cs.id = :secteurId')
            ->setParameter('secteurId', $secteurId)
            ->join('c.information', 'ci')
        ;

        if ($search->getPrenom()) {
            $query = $query
                ->andwhere('ci.lastname LIKE :lastname')
                ->orwhere('ci.firstname LIKE :lastname')
                ->setParameter('lastname', '%'.$search->getPrenom().'%');
        }
        if ($search->getEmail()) {
            $query = $query
                ->andwhere('ci.email LIKE :email')
                ->setParameter('email', '%'.$search->getEmail().'%');
        }
        if ($search->getTelephone()) {
            $query = $query
                ->andwhere('ci.phone LIKE :phone')
                ->setParameter('phone', '%'.$search->getTelephone().'%');
        }
        if ($search->getAdresse()) {
            $query = $query
                ->andwhere('ci.address LIKE :address')
                ->setParameter('address', '%'.$search->getAdresse().'%');
        }
        if ($search->getDateInscriptionMin()) {
            $query = $query
                ->andwhere('c.created_at >= :dateInscriptionMin')
                ->setParameter('dateInscriptionMin', $search->getDateInscriptionMin());
        }
        if ($search->getDateInscriptionMax()) {
            // On ajoute +1day, car la requête ne prend que la date en dessous de la date recherchée
            $search->getDateInscriptionMax()->add(new DateInterval('P1D'));

            $query = $query
                ->andwhere('c.created_at <= :dateInscriptionMax')
                ->setParameter('dateInscriptionMax', $search->getDateInscriptionMax());
        }

        if ($search->getTag()) {
            $query = $query->join('c.tags','tgs')
                            ->andWhere('tgs = :tag')
                ->setParameter('tag', $search->getTag());
        }
        if ($search->getType()) {
            $query = $query
                ->andwhere('ci.type = :type')
                ->setParameter('type', $search->getType());
        }

        if (isset($_GET['ordre'])) {
            if ($_GET['ordre'] == 'ASC') {
                $query = $query->orderBy('ci.lastname', 'ASC');
            }else {
                $query = $query->orderBy('ci.lastname', 'DESC');
            }
        }
      

        return $query->getQuery()
            ->getResult()
        ;
    }

    public function findByKeyWordQuery($keyword,$agent,$secteurId = null){
        if(is_null($secteurId)){
            $secteurId = $_ENV['SECTEUR_METHER_ID'];
        }
        $query = $this->createQueryBuilder('c');
        $query = $query
            ->andwhere('c.agent = :agent')
            ->setParameter('agent', $agent)
            ->join('c.secteur', 'cs')
            ->andwhere('cs.id = :secteurId')
            ->setParameter('secteurId', $secteurId)
            ->join('c.information', 'ci')
        ;

        $query->where(
            $query->expr()->orX(
                $query->expr()->like($query->expr()->lower('ci.lastname'), ':keyword'),    
                $query->expr()->like($query->expr()->lower('ci.firstname'), ':keyword'),    
                $query->expr()->like($query->expr()->lower('ci.email'), ':keyword'),    
                $query->expr()->like($query->expr()->lower('ci.phone'), ':keyword'),    
                $query->expr()->like($query->expr()->lower('ci.address'), ':keyword'),    
            )
            ) ->setParameters([
                'keyword' => '%' . strtolower($keyword) . '%',
            ]);
        
            return $query->getQuery()
            ->getResult()
        ;
       
    }


    // /**
    //  * @return Contact[] Returns an array of Contact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
