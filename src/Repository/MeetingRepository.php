<?php

namespace App\Repository;

use DateInterval;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Meeting;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\SearchEntity\MeetingSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Meeting>
 *
 * @method Meeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meeting[]    findAll()
 * @method Meeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meeting::class);
    }

    public function add(Meeting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Meeting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSearchQuery($meeting, $options = null){
        $qb = $this->createQueryBuilder('p');
        $parameters = [];
        if($meeting->getTitle()!=null) {
            $qb->andWhere('LOWER(p.title) LIKE LOWER(:title)');
            $parameters['title'] = '%'.$meeting->getTitle(). '%';
        }
        if($meeting->getStart()!=null) {
            $qb->andWhere("DATE(p.start) >= DATE(:start)");
            $parameters['start'] = $meeting->getStart();
        }
        if($meeting->getEnd()!=null) {
            $qb->andWhere("DATE(p.end) <= DATE(:end)");
            $parameters['end'] = $meeting->getEnd();
        }
        if($meeting->getMeetingState()!=null) {
            $qb->andWhere('p.meetingState = :meetingState');
            $parameters['meetingState'] = $meeting->getMeetingState();
        }
        if($meeting->getUser()!=null && $meeting->getUserToMeet()!=null) {
            $qb->andWhere('p.user = :user or p.userToMeet = :userToMeet');
            $parameters['user'] = $meeting->getUser();
            $parameters['userToMeet'] = $meeting->getUserToMeet();
        }
        if($options != null){
            if($options['orderBy']!=null && $options['order']!=null) {
                $qb->orderBy('p.'.$options['orderBy'], $options['order']);
            } 
        }

        $qb->setParameters($parameters);
        return $qb->getQuery();

    }

    /**
     * @param MeetingSearch $search
     * @return Query
     */
    public function findMeetingByUser(MeetingSearch $search, User $user,Contact $contact = null,Array $options = null )
    {
        $query = $this->createQueryBuilder('m');
        if($options && isset($options['secteur'])){
            $query = $query
            ->andwhere('m.secteur = :secteur')
            ->setParameter('secteur',$options['secteur']);   
        }else{
            $query = $query
                ->andwhere('m.user = :user')
                ->setParameter('user', $user)
            ;
        }

        if ($search->getTitle()) {
            $query = $query
                ->andwhere('m.title LIKE :title')
                ->setParameter('title', '%'.$search->getTitle().'%');
        }
        if ($search->getStartDate()) {
            $query = $query
                ->andwhere('m.start >= :startDate')
                ->setParameter('startDate', $search->getStartDate());
        }
        if ($search->getEndDate()) {
            // On ajoute +1day, car la requête ne prend que la date en dessous de la date recherchée
            $search->getEndDate()->add(new DateInterval('P1D'));

            $query = $query
                ->andwhere('m.end <= :endDate')
                ->setParameter('endDate', $search->getEndDate());
        }
        if ($search->getStatus()) {
            $query = $query
                ->join('m.meetingState', 'ms')
                ->andwhere('ms.name LIKE :status')
                ->setParameter('status', $search->getStatus());
        }

       
        if($contact){
            $query = $query
                ->andwhere('m.userToMeet = :userToMeet')
                ->setParameter('userToMeet', $contact);
        }

        return $query
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Meeting[] Returns an array of Meeting objects
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

//    public function findOneBySomeField($value): ?Meeting
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
