<?php

namespace App\Repository;

use DateInterval;
use App\Entity\Prospect;
use App\Entity\SearchEntity\UserSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Prospect>
 *
 * @method Prospect|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prospect|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prospect[]    findAll()
 * @method Prospect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prospect::class);
    }

       /**
     * @param UserSearch $search
     * @param string $role
     * @return Query
     */
    public function findProspect(UserSearch $search, $agent)
    {
        $query = $this->createQueryBuilder('c');
        $query = $query
                ->andwhere('c.agent = :agent')
                ->setParameter('agent',$agent->getId());

        if ($search->getPrenom()) {
            $query = $query
                ->andwhere('c.lastname LIKE :lastname')
                ->orwhere('c.firstname LIKE :lastname')
                ->setParameter('lastname', '%'.$search->getPrenom().'%');
        }
        if ($search->getEmail()) {
            $query = $query
                ->andwhere('c.email LIKE :email')
                ->setParameter('email', '%'.$search->getEmail().'%');
        }
        if ($search->getTelephone()) {
            $query = $query
                ->andwhere('c.phone LIKE :phone')
                ->setParameter('phone', '%'.$search->getTelephone().'%');
        }
        if ($search->getAdresse()) {
            $query = $query
                ->andwhere('c.address LIKE :address')
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

        
        if ($search->getType()) {
            $query = $query
                ->andwhere('c.type = :type')
                ->setParameter('type', $search->getType());
        }

        if (isset($_GET['ordre'])) {
            if ($_GET['ordre'] == 'ASC') {
                $query = $query->orderBy('c.lastname', 'ASC');
            }else {
                $query = $query->orderBy('c.lastname', 'DESC');
            }
        }
      

        return $query->getQuery()
            ->getResult()
        ;
    }

    public function checkExistingProspect($data){
        $qb = $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.firstname = :nom')
            ->andWhere('p.lastname = :prenom')
            ->andWhere('p.email = :email')
            ->setParameter('nom', $data['nom'])
            ->setParameter('prenom', $data['prenom'])
            ->setParameter('email', $data['email']);
 
        $result =   $qb->getQuery()
            ->getSingleScalarResult();
        ;
        return $result > 0 ? true : false;
    }

//    /**
//     * @return Prospect[] Returns an array of Prospect objects
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

//    public function findOneBySomeField($value): ?Prospect
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}