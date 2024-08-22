<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\CallScript;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CallScript>
 *
 * @method CallScript|null find($id, $lockMode = null, $lockVersion = null)
 * @method CallScript|null findOneBy(array $criteria, array $orderBy = null)
 * @method CallScript[]    findAll()
 * @method CallScript[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CallScriptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CallScript::class);
    }

    public function getQueryForFindAllScript(User $user,Secteur $secteur){
        $query= $this->createQueryBuilder('c')
            ->leftJoin('c.secteur', 's')
            ->leftJoin('c.author', 'u');
        if(in_array(User::ROLE_COACH,$user->getRoles())){
            $query->andWhere('c.author = :user')
            ->andWhere('c.secteur = :secteur')
            ->setParameter('user',$user)
            ->setParameter('secteur',$secteur);
        }elseif(in_array(User::ROLE_AGENT,$user->getRoles())){
            $query->andWhere(
                $query->expr()->orX(
                    $query->expr()->andX(
                        'JSON_CONTAINS(u.roles, :role) = 1',
                        $query->expr()->eq('c.secteur', ':secteur')
                    ),
                    $query->expr()->andX(
                        $query->expr()->eq('c.author', ':author')
                    )
                )
            )
            ->setParameter('author', $user)
            ->setParameter('role',json_encode(User::ROLE_COACH))
            ->setParameter('secteur', $secteur);
        }
        return   $query;
    }

    public function findAllScript(User $user,Secteur $secteur){
       
        return $this->getQueryForFindAllScript($user,$secteur)->getQuery()->getResult()
       ;
    }

    public function findFirstAvailableScript(User $user,Secteur $secteur){
        return $this->getQueryForFindAllScript($user,$secteur)    
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return CallScript[] Returns an array of CallScript objects
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

//    public function findOneBySomeField($value): ?CallScript
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
