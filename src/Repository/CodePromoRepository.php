<?php

namespace App\Repository;

use App\Entity\CodePromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodePromo>
 *
 * @method CodePromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodePromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodePromo[]    findAll()
 * @method CodePromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodePromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodePromo::class);
    }

//    /**
//     * @return CodePromo[] Returns an array of CodePromo objects
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

//    public function findOneBySomeField($value): ?CodePromo
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function checkCodePromoValidity($code,$countryCode,$secteurId){
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->leftJoin('c.codePromoCountries', 'cpc')
            ->where('cpc.countryCode = :countryCode')  
            ->andWhere('c.code = :code')  
            ->andWhere('c.secteur = :secteur')  
            ->andWhere(':now >= c.startDate')  
            ->andWhere('c.endDate IS NULL OR :now <= c.endDate')  
            ->setParameter('countryCode', $countryCode)  
            ->setParameter('code', TRIM($code))  
            ->setParameter('secteur', $secteurId)  
            ->setParameter('now', (new \DateTime)->format('Y-m-d H:i:s'))  
            ->orderBy('c.startDate', 'ASC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

}
