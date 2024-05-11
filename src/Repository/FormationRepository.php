<?php

namespace App\Repository;

use App\Entity\CategorieFormation;
use App\Entity\Formation;
use App\Entity\Secteur;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    protected $repoFormationAgent;

    public function __construct(ManagerRegistry $registry, FormationAgentRepository $repoFormationAgent)
    {
        parent::__construct($registry, Formation::class);
        $this->repoFormationAgent = $repoFormationAgent;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Formation $entity, bool $flush = true): void
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
    public function remove(Formation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Formation[] Returns an array of Formation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findBySecteur(Secteur $secteur)
    {
            return $this->createQueryBuilder('f')
                ->where('f.secteur=:secteur')
                ->setParameter('secteur',$secteur->getId())
                ->getQuery();
    }

    public function findFormationsCoach(?array $criteres, Secteur $secteur)
    {

        $queryBuilder = ($this->createQueryBuilder('f'))->where('f.secteur=:secteur')
        ->setParameter('secteur',$secteur->getId());
        if(isset($criteres['titre']) && !empty($criteres['titre'])) {
            $queryBuilder->andWhere('f.titre LIKE :titre')
                ->setParameter('titre', '%'.$criteres['titre'].'%');
        }
        if(isset($criteres['description']) && !empty($criteres['description'])) {
            $queryBuilder->andWhere('f.description LIKE :description')
                ->setParameter('description', '%'.$criteres['description'].'%');
        }
        if(isset($criteres['etat'])) {
            $etat = trim($criteres['etat']);
            if($etat != ""){
                $etat = $criteres['etat'];
                $queryBuilder->andWhere('f.statut = :etat')
                    ->setParameter('etat', $etat);
            }
        }
        $queryBuilder->andWhere('f.statut != :statusDeleted')
            ->setParameter('statusDeleted', Formation::STATUS_DELETED);

        if(isset($criteres['auteur']) && !empty($criteres['auteur'])) {
            $queryBuilder->innerJoin('App\Entity\User', 'u', 'ON')
                ->andWhere('u.nom LIKE :nom')
                ->setParameter('nom', '%'.$criteres['auteur'].'%');
        }
        if(isset($criteres['trie']) && !empty($criteres['trie'])) {
            $queryBuilder->orderBy('f.'.$criteres['trie'], $criteres['ordre']);
        }


        if (isset($criteres['categorie'])) {
            $queryBuilder
                ->join('f.CategorieFormation', 'cf')
                ->andwhere('cf.nom LIKE :nomCategorie')
                ->setParameter('nomCategorie', '%'.$criteres['categorie'].'%')
            ;           
        }

      return $queryBuilder->getQuery();

    }

    public function searchForCoach(?array $criteres, Secteur $secteur)
    {

        $queryBuilder = ($this->createQueryBuilder('f'))->where('f.secteur=:secteur')
        ->setParameter('secteur',$secteur->getId());
        if(!empty($criteres['titre'])) {
            $queryBuilder->andWhere('f.titre LIKE :titre')
                ->setParameter('titre', '%'.$criteres['titre'].'%');
        }
        if(!empty($criteres['description'])) {
            $queryBuilder->andWhere('f.description LIKE :description')
                ->setParameter('description', '%'.$criteres['description'].'%');
        }
        if(!empty($criteres['etat'])) {
            switch ($criteres['etat']) {
                case 'disponible' :   $queryBuilder->andWhere('f.debloqueAgent = :etat')
                    ->setParameter('etat', true );
                    break;
                case 'brouillon' : $queryBuilder->andWhere('f.brouillon = :etat')
                    ->setParameter('etat', true );
                break;
            }

        }
        if(!empty($criteres['auteur'])) {
            $queryBuilder->innerJoin('App\Entity\User', 'u', 'ON')
                ->andWhere('u.nom LIKE :nom')
                ->setParameter('nom', '%'.$criteres['auteur'].'%');
        }
        if(!empty($criteres['trie'])) {
            $queryBuilder->orderBy('f.'.$criteres['trie'], $criteres['ordre']);
        }


        if (isset($criteres['categorie'])) {
            $queryBuilder
                ->join('f.CategorieFormation', 'cf')
                ->andwhere('cf.nom LIKE :nomCategorie')
                ->setParameter('nomCategorie', '%'.$criteres['categorie'].'%')
            ;           
        }

      return $queryBuilder->getQuery();

    }

    public function searchForAgent(?array $criteres, $secteur)
    {
        $queryBuilder = ($this->createQueryBuilder('f'))->where('f.secteur=:secteur')
            ->setParameter('secteur',$secteur->getId());
        $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->isNull('f.brouillon'),
                $queryBuilder->expr()->eq('f.brouillon', ':brouillon')
            ))->setParameter('brouillon', 0)
        ;
        if(!empty($criteres['titre'])) {
            $queryBuilder->andWhere('f.titre LIKE :titre')
                ->setParameter('titre', '%'.$criteres['titre'].'%');
        }
        if(!empty($criteres['description'])) {
            $queryBuilder->andWhere('f.description LIKE :description')
                ->setParameter('description', '%'.$criteres['description'].'%');
        }
        $queryBuilder->andWhere('f.statut = :statusCreated')
            ->setParameter('statusCreated', Formation::STATUS_CREATED);

        if(!empty($criteres['auteur'])) {
            $queryBuilder->innerJoin('App\Entity\User', 'u', 'ON')
                ->andWhere('u.nom LIKE :nom')
                ->setParameter('nom', '%'.$criteres['auteur'].'%');
        }
        if(!empty($criteres['trie'])) {
            $queryBuilder->orderBy('f.'.$criteres['trie'], $criteres['ordre']);
        }

        if (isset($criteres['categorie'])) {
            $queryBuilder
                ->join('f.CategorieFormation', 'cf')
                ->andwhere('cf.nom LIKE :nomCategorie')
                ->setParameter('nomCategorie', '%'.$criteres['categorie'].'%')
            ;           
        }
        
//        dd((string) $queryBuilder);

        return $queryBuilder->getQuery();
    }

    public function getNextFormationsByCategorieAndSecteur($secteur, $categorie, $formationId)
    {
       $qb = $this->createQueryBuilder('f');

        return $qb->andWhere('f.CategorieFormation = :categorie')
        ->andWhere('f.secteur = :secteur')
        ->andWhere('f.id > :formationId')
        ->andWhere($qb->expr()->orX(
            $qb->expr()->isNull('f.brouillon'),
            $qb->expr()->eq('f.brouillon', ':brouillon')
        ))->setParameter('brouillon', 0)
        ->andWhere('f.statut = :statusCreated')
            ->setParameter('statusCreated', Formation::STATUS_CREATED)
        ->setParameter('categorie', $categorie)
        ->setParameter('secteur', $secteur)
        ->setParameter('formationId', $formationId)
        ->orderBy('f.id', 'ASC')
        ->getQuery()
        ->getResult();
    }


    public function findFormationsAgent(?array $criteres, $secteur)
    {
        $queryBuilder = ($this->createQueryBuilder('f'))
            ->where('f.secteur=:secteur')
            ->setParameter('secteur',$secteur->getId())
            ->andWhere('f.brouillon=:brouillon')
            ->setParameter('brouillon', false);
        if(isset($criteres['titre']) && !empty($criteres['titre'])) {
            $queryBuilder->andWhere('f.titre LIKE :titre')
                ->setParameter('titre', '%'.$criteres['titre'].'%');
        }
        if(isset($criteres['description']) && !empty($criteres['description'])) {
            $queryBuilder->andWhere('f.description LIKE :description')
                ->setParameter('description', '%'.$criteres['description'].'%');
        }
        if(isset($criteres['etat']) && !empty($criteres['etat'])) {
            switch ($criteres['etat']) {
                case 'bloquee' :
                    $queryBuilder->andWhere('f.debloqueAgent = :etat')
                        ->setParameter('etat', false ); break;
                case 'disponible' :   $queryBuilder->andWhere('f.debloqueAgent = :etat')
                    ->setParameter('etat', true );
                    break;
            }

        }
        if(isset($criteres['auteur']) && !empty($criteres['auteur'])) {
            $queryBuilder->innerJoin('App\Entity\User', 'u', 'ON')
                ->andWhere('u.nom LIKE :nom')
                ->setParameter('nom', '%'.$criteres['auteur'].'%');
        }
        if(isset($criteres['trie']) && !empty($criteres['trie'])) {
            $queryBuilder->orderBy('f.'.$criteres['trie'], $criteres['ordre']);
        }

        if (isset($criteres['categorie'])) {
            $queryBuilder
                ->join('f.CategorieFormation', 'cf')
                ->andwhere('cf.nom LIKE :nomCategorie')
                ->setParameter('nomCategorie', '%'.$criteres['categorie'].'%')
            ;           
        }
        
//        dd((string) $queryBuilder);

        return $queryBuilder->getQuery();
    }

    public function AgentfindBySecteur($secteur)
    {
        return $this->createQueryBuilder('f')
            ->where('f.secteur=:secteur')
            ->andWhere('f.brouillon=false')
            ->setParameter('secteur',$secteur->getId())
            ->getQuery();
    }

    public function findOrderedNonFinishedFormations(Secteur $secteur, User $agent){
        $qb = $this->createQueryBuilder('f');
        $qb->join('f.CategorieFormation', 'cf')
            ->leftJoin('f.formationAgents', 'fa', \Doctrine\ORM\Query\Expr\Join::WITH, 'fa.agent=:agent')
            ->andWhere('f.secteur=:secteur')
            ->andWhere('f.statut=:statusCreated')
            ->andWhere('f.brouillon is NULL or f.brouillon =0')
            ->andWhere('fa.agent is NULL OR fa.statut != :finishedStatus')
            ->setParameter('secteur',$secteur->getId())
            ->setParameter('agent', $agent->getId())
            ->setParameter('finishedStatus', Formation::STATUT_TERMINER)
            ->setParameter('statusCreated', Formation::STATUS_CREATED)
            ->addOrderBy('cf.ordreCatFormation')
            ->addOrderBy('f.id');
        return $qb->getQuery()->getResult();    
    }

    /**
     * Permet de recupérer les formations de l'agent en fonction du secteur et de la catégorie
     *
     * @param Secteur $secteur
     * @param CategorieFormation $categorie
     * @param boolean $excludeFormationDone
     */
    public function findFormationsAgentBySecteurAndCategorie(Secteur $secteur, User $agent, CategorieFormation $categorie = null, $excludeFormationDone = false)
    {
        $queryBuilder = $this->createQueryBuilder('f');
        
        $queryBuilder
            ->where('f.secteur=:secteur')
            ->andWhere('f.brouillon=false')
            ->setParameter('secteur',$secteur->getId())
            ->join('f.CategorieFormation', 'cf')
            ->join('f.formationAgents', 'fa')
            ->andWhere('fa.agent = :agent')
            ->setParameter('agent', $agent->getId())
        ;
            
        if ($categorie) {
            $queryBuilder
                ->andWhere('cf.nom = :category')
                ->setParameter('category', $categorie->getNom())
            ;
        }

        
        // // Lorsqu'on met $excludeFormationDone à true, on exclut les formations terminées
        if ($excludeFormationDone === true) {
            $statutBloquee = Formation::STATUT_BLOQUEE;
            $statutTerminee = Formation::STATUT_TERMINER;
            $queryBuilder
                ->andWhere('fa.statut NOT LIKE :statutBloquee')
                ->andWhere('fa.statut NOT LIKE :statutTerminee')
                ->setParameter('statutBloquee', '%'.$statutBloquee.'%' )
                ->setParameter('statutTerminee', '%'.$statutTerminee.'%' );
        }


        return $queryBuilder->getQuery()->getResult();
    }
}
