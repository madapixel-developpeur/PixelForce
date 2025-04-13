<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserOTP;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<UserOTP>
 *
 * @method UserOTP|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserOTP|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserOTP[]    findAll()
 * @method UserOTP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserOTPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOTP::class);
    }

//    /**
//     * @return UserOTP[] Returns an array of UserOTP objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserOTP
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findOtp($operationType, string $value, ?User $user = null, ?string $email = null): ?UserOTP
   {
       $q = $this->createQueryBuilder('u')
           ->andWhere('u.value = :val')
           ->andWhere('u.status = :status')
           ->andWhere('u.operationType = :operationType')
           ->setParameter('val', sha1($value))
           ->setParameter('status', UserOTP::STATUS_CREATED)
           ->setParameter('operationType', $operationType)
       ;
       if ($email){
        $q->andWhere('lower(u.email) = lower(:email)')
        ->setParameter('email', $email);
       }
       else{
        $q->andWhere('u.user = :user')
            ->setParameter('user', $user);
       } 

    return $q->getQuery()
    ->getOneOrNullResult();
   }
}
