<?php

namespace App\Repository;

use DateInterval;
use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\NewsLetters;
use App\Entity\AgentSecteur;
use App\Entity\CanalMessage;
use App\Entity\CoachSecteur;
use Doctrine\ORM\ORMException;
use App\Entity\SearchEntity\UserSearch;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    protected $repoCoachSecteur;
    protected $repoAgentSecteur;

    public function __construct(ManagerRegistry $registry, CoachSecteurRepository $repoCoachSecteur, AgentSecteurRepository $repoAgentSecteur)
    {
        parent::__construct($registry, User::class);
        $this->repoCoachSecteur = $repoCoachSecteur;
        $this->repoAgentSecteur = $repoAgentSecteur;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $entity, bool $flush = true): void
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
    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findDestinaire($finder, User $currentUser)
    {
        // select * from user inner join agent_secteur on agent_secteur.agent_id=user.id innerjoin secteur on agent_secteur.secteur=secteur.
        $arrayFinder = explode(' ', $finder);
        $queryBuilder = $this->createQueryBuilder('u');
        foreach($arrayFinder as $realFinder) {
            $queryBuilder->orWhere('u.nom LIKE :finder')
                ->orWhere('u.prenom LIKE :finder')
                ->orWhere('u.email LIKE :finder')
                ->setParameter('finder', '%'.$realFinder.'%');
        }
        if(in_array(User::ROLE_COACH, $currentUser->getRoles())) {
            $secteur = $currentUser->getSecteurByCoach();
            $queryBuilder = $queryBuilder->innerJoin(AgentSecteur::class, 'a', 'WITH', 'a.agent=u.id')
                ->innerJoin(Secteur::class, 's', 'WITH', 'a.secteur=s.id')
                ->andWhere('u.roles LIKE :role')
                ->andWhere('s.id=:secteur')
                ->setParameter('secteur', $secteur)
                ->setParameter('role', '%'.User::ROLE_AGENT.'%')
            ;

        }
        if(in_array(User::ROLE_AGENT, $currentUser->getRoles())) {
            $secteurs = $currentUser->getSecteursIdsByAgent();
            $queryBuilder = $queryBuilder->innerJoin(CoachSecteur::class, 'a', 'WITH', 'a.coach=u.id')
                ->innerJoin(Secteur::class, 's', 'WITH', 'a.secteur=s.id')
                ->andWhere('u.roles LIKE :role')
                ->andWhere('s.id in (:secteurs)')
                ->setParameter('secteurs', $secteurs)
                ->setParameter('role', '%'.User::ROLE_COACH.'%')
            ;

        }

       return $queryBuilder->getQuery()
            ->getResult();
    }

    public function getUserByCanal(CanalMessage $canal)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->leftJoin('a.canalMessages', 'c')
            ->addSelect('c');

        $query = $query->add('where', $query->expr()->in('c', ':c'))
            ->setParameter('c', $canal)
            ->getQuery()
            ->getResult();

        return $query;
    }

    

    /**
     * Permet de filtrer les utilisateurs (Coach ou Agent)
     *
     * @param UserSearch $search
     * @param string $role (COACH | AGENT)
     */
    public function findCoachOrAgentQuery(UserSearch $search, string $role)
    {
        $query = $this->createQueryBuilder('u');

        $query = $query
            ->where('u.roles LIKE :role')
            ->setParameter('role', "%$role%");

        if($search->getActive()) {
            $query = $query
                ->andwhere('u.active = :active')
                ->setParameter('active', $search->getActive());
        }

        if ($search->getPrenom()) {
            $query = $query
                ->andwhere('u.prenom LIKE :prenom')
                ->orwhere('u.nom LIKE :prenom')
                ->setParameter('prenom', '%'.$search->getPrenom().'%');
        }
        if ($search->getEmail()) {
            $query = $query
                ->andwhere('u.email LIKE :email')
                ->setParameter('email', '%'.$search->getEmail().'%');
        }
        if ($search->getTelephone()) {
            $query = $query
                ->andwhere('u.telephone LIKE :telephone')
                ->setParameter('telephone', '%'.$search->getTelephone().'%');
        }
        if ($search->getDateInscriptionMin()) {
            $query = $query
                ->andwhere('u.created_at >= :dateInscriptionMin')
                ->setParameter('dateInscriptionMin', $search->getDateInscriptionMin());
        }
        if ($search->getDateInscriptionMax()) {
            // On ajoute +1day, car la requête ne prend que la date en dessous de la date recherchée
            $search->getDateInscriptionMax()->add(new DateInterval('P1D'));

            $query = $query
                ->andwhere('u.created_at <= :dateInscriptionMax')
                ->setParameter('dateInscriptionMax', $search->getDateInscriptionMax());
        }
        if ($search->getSecteur()) {
            if ($role === User::ROLE_COACH) {
                $query = $query
                    ->join('u.coachSecteurs', 'cs')
                    ->join('cs.secteur', 's')
                    ->andwhere('s.nom LIKE :nomSecteur')
                    ->setParameter('nomSecteur', '%'.$search->getSecteur()->getNom().'%');
            }else if($role === User::ROLE_AGENT){
                $query = $query
                    ->join('u.agentSecteurs', 'aSec')
                    ->join('aSec.secteur', 'tre')
                    ->andwhere('tre.nom LIKE :nomSecteur')
                    ->setParameter('nomSecteur', '%'.$search->getSecteur()->getNom().'%')
                ;
            }
        }

        return $query->getQuery()
            ->getResult()
        ;
    }
    /**
     * Permet de filtrer les utilisateurs (Coach ou Agent)
     *
     * @param UserSearch $search
     * @param string $role (COACH | AGENT)
     */
    public function findCoachQuery(UserSearch $search, string $role)
    {
        $query = $this->createQueryBuilder('u');
        $query = $query
            ->where('u.roles LIKE :role')
            ->setParameter('role', "%$role%");

        if($search->getActive()) {
            $query = $query
                ->andwhere('u.active = :active')
                ->setParameter('active', $search->getActive());
        }

        if ($search->getPrenom()) {
            $query = $query
                ->andwhere('u.prenom LIKE :prenom')
                ->orwhere('u.nom LIKE :prenom')
                ->setParameter('prenom', '%'.$search->getPrenom().'%');
        }
        if ($search->getEmail()) {
            $query = $query
                ->andwhere('u.email LIKE :email')
                ->setParameter('email', '%'.$search->getEmail().'%');
        }
        if ($search->getTelephone()) {
            $query = $query
                ->andwhere('u.telephone LIKE :telephone')
                ->setParameter('telephone', '%'.$search->getTelephone().'%');
        }
        if ($search->getDateInscriptionMin()) {
            $query = $query
                ->andwhere('u.created_at >= :dateInscriptionMin')
                ->setParameter('dateInscriptionMin', $search->getDateInscriptionMin());
        }
        if ($search->getDateInscriptionMax()) {
            // On ajoute +1day, car la requête ne prend que la date en dessous de la date recherchée
            $search->getDateInscriptionMax()->add(new DateInterval('P1D'));

            $query = $query
                ->andwhere('u.created_at <= :dateInscriptionMax')
                ->setParameter('dateInscriptionMax', $search->getDateInscriptionMax());
        }
        if ($search->getSecteur()) {
            if ($role === User::ROLE_COACH) {
                $query = $query
                    ->join('u.coachSecteurs', 'cs')
                    ->join('cs.secteur', 's')
                    ->andwhere('s.nom LIKE :nomSecteur')
                    ->setParameter('nomSecteur', '%'.$search->getSecteur()->getNom().'%');
            }else if($role === User::ROLE_AGENT){
                $query = $query
                    ->join('u.agentSecteurs', 'aSec')
                    ->join('aSec.secteur', 'tre')
                    ->andwhere('tre.nom LIKE :nomSecteur')
                    ->setParameter('nomSecteur', '%'.$search->getSecteur()->getNom().'%')
                ;
            }
        }


        return $query->getQuery()
            ->getResult()
        ;
    }



    /**
     * Permet de filtrer tous les agents du coach
     *
     * @param UserSearch $search
     * @param string $role
     * @return array
     */
    public function findAgentByCoach(UserSearch $search, $coach)
    {
        $secteur = $this->repoCoachSecteur->findBy(['coach' => $coach]);
        $secteur = isset($secteur[0]) ? $secteur[0]->getSecteur() : null;

        $query = $this->createQueryBuilder('a')
                ->where('a.active IS NULL or a.active != :inactiveState')
                ->setParameter('inactiveState', User::INACTIVE_STATE);

        if ($search->getPrenom()) {
            $query = $query
                ->andwhere('a.prenom LIKE :prenom')
                ->orwhere('a.nom LIKE :prenom')
                ->setParameter('prenom', '%'.$search->getPrenom().'%');
        }

        
        if ($search->getEmail()) {
            $query = $query
                ->andwhere('a.email LIKE :email')
                ->setParameter('email', '%'.$search->getEmail().'%');
        }
        if ($search->getTelephone()) {
            $query = $query
                ->andwhere('a.telephone LIKE :telephone')
                ->setParameter('telephone', '%'.$search->getTelephone().'%');
        }
        if ($search->getDateInscriptionMin()) {
            $query = $query
                ->andwhere('a.created_at >= :dateInscriptionMin')
                ->setParameter('dateInscriptionMin', $search->getDateInscriptionMin());
        }
        if ($search->getDateInscriptionMax()) {
            // On ajoute +1day, car la requête ne prend que la date en dessous de la date recherchée
            $search->getDateInscriptionMax()->add(new DateInterval('P1D'));

            $query = $query
                ->andwhere('a.created_at <= :dateInscriptionMax')
                ->setParameter('dateInscriptionMax', $search->getDateInscriptionMax());
        }

        $query = $query
            ->join('a.agentSecteurs', 'aSec')
            ->andwhere('aSec.secteur = :secteur')
            ->setParameter('secteur', $secteur)
            ->orderBy('a.id', 'DESC')
        ;   

        return $query->getQuery()
            ->getResult()
        ;
    }

    public function findCoachBySecteur(UserSearch $search, Secteur $secteur)
    {
        $query = $this->createQueryBuilder('a')
        ->where('a.roles LIKE :role')
        ->andWhere('a.active=1')
        ->setParameter('role', '%'.User::ROLE_COACH.'%');

        if ($search->getPrenom()) {
            $query = $query
                ->andwhere('a.prenom LIKE :prenom')
                ->orwhere('a.nom LIKE :prenom')
                ->setParameter('prenom', '%'.$search->getPrenom().'%');
        }


        if ($search->getEmail()) {
            $query = $query
                ->andwhere('a.email LIKE :email')
                ->setParameter('email', '%'.$search->getEmail().'%');
        }
        if ($search->getTelephone()) {
            $query = $query
                ->andwhere('a.telephone LIKE :telephone')
                ->setParameter('telephone', '%'.$search->getTelephone().'%');
        }
        if ($search->getDateInscriptionMin()) {
            $query = $query
                ->andwhere('a.created_at >= :dateInscriptionMin')
                ->setParameter('dateInscriptionMin', $search->getDateInscriptionMin());
        }
        if ($search->getDateInscriptionMax()) {
            // On ajoute +1day, car la requête ne prend que la date en dessous de la date recherchée
            $search->getDateInscriptionMax()->add(new DateInterval('P1D'));

            $query = $query
                ->andwhere('a.created_at <= :dateInscriptionMax')
                ->setParameter('dateInscriptionMax', $search->getDateInscriptionMax());
        }

        $query = $query
            ->join('a.coachSecteurs', 'aSec')
            ->andwhere('aSec.secteur = :secteur')
            ->setParameter('secteur', $secteur)
            ->orderBy('a.id', 'DESC')
        ;

        return $query->getQuery()
            ->getResult()
            ;
    }

    public function findAgentByToken($token): ?User
    {
        $result = $this->createQueryBuilder('u')
            ->where('( u.active > 0 or u.active is NULL ) and lower(sha1(u.id)) = lower(:token)')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        
        if($result && in_array('ROLE_AGENT', $result->getRoles())){
            return $result;
        }
        return null;
    }

    public function findFilsQuery(int $role)
    {
        $query = $this->createQueryBuilder('u');
        $query = $query
            ->where('u.roles LIKE :role')
            ->setParameter('role', "%$role%");

        if($search->getActive()) {
            $query = $query
                ->andwhere('u.active = :active')
                ->setParameter('active', $search->getActive());
        }

        if ($search->getPrenom()) {
            $query = $query
                ->andwhere('u.prenom LIKE :prenom')
                ->orwhere('u.nom LIKE :prenom')
                ->setParameter('prenom', '%'.$search->getPrenom().'%');
        }
        if ($search->getEmail()) {
            $query = $query
                ->andwhere('u.email LIKE :email')
                ->setParameter('email', '%'.$search->getEmail().'%');
        }
        if ($search->getTelephone()) {
            $query = $query
                ->andwhere('u.telephone LIKE :telephone')
                ->setParameter('telephone', '%'.$search->getTelephone().'%');
        }
        if ($search->getDateInscriptionMin()) {
            $query = $query
                ->andwhere('u.created_at >= :dateInscriptionMin')
                ->setParameter('dateInscriptionMin', $search->getDateInscriptionMin());
        }
        if ($search->getDateInscriptionMax()) {
            // On ajoute +1day, car la requête ne prend que la date en dessous de la date recherchée
            $search->getDateInscriptionMax()->add(new DateInterval('P1D'));

            $query = $query
                ->andwhere('u.created_at <= :dateInscriptionMax')
                ->setParameter('dateInscriptionMax', $search->getDateInscriptionMax());
        }
        if ($search->getSecteur()) {
            if ($role === User::ROLE_COACH) {
                $query = $query
                    ->join('u.coachSecteurs', 'cs')
                    ->join('cs.secteur', 's')
                    ->andwhere('s.nom LIKE :nomSecteur')
                    ->setParameter('nomSecteur', '%'.$search->getSecteur()->getNom().'%');
            }else if($role === User::ROLE_AGENT){
                $query = $query
                    ->join('u.agentSecteurs', 'aSec')
                    ->join('aSec.secteur', 'tre')
                    ->andwhere('tre.nom LIKE :nomSecteur')
                    ->setParameter('nomSecteur', '%'.$search->getSecteur()->getNom().'%')
                ;
            }
        }


        return $query->getQuery()
            ->getResult()
        ;
    }

    public function getAgentFilsDirect($agentIds){
        return $this->createQueryBuilder('u')
            // ->andWhere("u.roles like '%\"ROLE_AGENT\"%'")
            ->andWhere('u.parrain IN (:agentIds)')
            ->setParameter('agentIds', $agentIds)
            ->getQuery()
            ->getResult();
    }

    public function getFilsJusqueNiveau($agentId, $niveau=3, $toId = false){
        $result = [];
        $params = [$agentId];
        for ($i = 0; $i < $niveau; $i++) {
            $fils = $this->getAgentFilsDirect($params);
            $params = array_map(function ($item){ return $item->getId(); }, $fils);
            $result[] = $toId ? $params : $fils;
        }
        return $result;
    }
    public function countDirectChildren(User $user)
    {
        return $this->createQueryBuilder('u')
        ->select('count(u.id)')
        ->where('u.parrain = :parrain')
        ->setParameter('parrain', $user)
        ->getQuery()
        ->getSingleScalarResult();
    }

    public function findByKeyWordQuery($keyWord, $secteurId = null){
        if(is_null($secteurId)){
            $secteurId = $_ENV['SECTEUR_METHER_ID'];
        }
        $query =  $this->createQueryBuilder('a')
                ->where('a.prenom LIKE :keyword')
                ->orWhere('a.nom LIKE :keyword')
                ->orWhere('a.email LIKE :keyword')
                ->orWhere('a.telephone LIKE :keyword')
                ->setParameter('keyword', '%'.$keyWord.'%')
                ->orderBy('a.nom','ASC')
        ;

        $query = $query
            ->join('a.coachSecteurs', 'aSec')
            ->andwhere('aSec.secteur = :secteur')
            ->setParameter('secteur', $secteurId)
            ->orderBy('a.id', 'DESC')
        ;

        
        return $query->getQuery()
            ->getResult()
            ;


    }

    public function getListOfEmailsCombinedWithpProspect(){
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('email', 'email');
     
        $sql = "
            SELECT DISTINCT email FROM (
                SELECT email FROM user
                UNION
                SELECT email FROM prospect
            ) as combined_emails
        ";
        $query =  $this->getEntityManager()->createNativeQuery($sql,$rsm);
        $query->setParameter('state', NewsLetters::SENT);
        $result = $query->getResult();
        return $result;

    }

    public function changeStateNewsLetters($state)
    {
        $query = "UPDATE App\Entity\User r SET r.newsLettersState = :state ";
        $params = ['state' => $state ];

        $this->getEntityManager()
            ->createQuery($query)
            ->execute($params);

    }
  
    
}
