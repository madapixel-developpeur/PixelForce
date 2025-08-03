<?php

namespace App\Repository;

use App\Entity\Secteur;
use App\Manager\EntityManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Secteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Secteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Secteur[]    findAll()
 * @method Secteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecteurRepository extends ServiceEntityRepository
{
    protected $repoCoachSecteur;
    protected $entityManager;

    public function __construct(ManagerRegistry $registry, CoachSecteurRepository $repoCoachSecteur, EntityManager $entityManager)
    {
        parent::__construct($registry, Secteur::class);
        $this->repoCoachSecteur = $repoCoachSecteur;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Secteur $entity, bool $flush = true): void
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
    public function remove(Secteur $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Permet de supprimer un secteur et la relation coachSecteur
     *
     * NB: On doit suivre cette procédure pour eviter l'erreur de "Violation de relation"
     */
    public function removeSectorAndCoachSecteur(Secteur $sector)
    {
        // (1) => On supprime d'abord toutes les relations entre coach et agent
        $coachSecteur = $this->repoCoachSecteur->findOneBy(['secteur' => $sector]);
        if ($coachSecteur) {
            $this->entityManager->delete($coachSecteur);
        }
        
        // (2) => Et enfin on supprime le secteur en question
        $this->entityManager->delete($sector);
    }

    public function getValidSecteurs() {
        return $this->createQueryBuilder('s')
            ->andWhere('s.active = 1')
            ->getQuery()
            ->getResult(); 
    }

     public function getStatValidSecteur() {
        return $this->createQueryBuilder('s')
            ->select('s.nom AS secteur, COUNT(DISTINCT ast.agent) AS total')
            ->leftJoin('s.agentSecteurs', 'ast', 'WITH', 's.id = ast.secteur')
            ->andWhere('s.active = :active')
            ->setParameter('active',Secteur::ACTIVE_STATE)
            ->groupBy('s')
            ->orderBy('total','DESC')
            ->getQuery()
            ->getResult(); 
    }

    // /**
    //  * @return Secteur[] Returns an array of Secteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Secteur
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllActive()
    {
        return $this->createQueryBuilder('s')
            ->addSelect('(CASE WHEN s.appearanceOrder IS NULL THEN 1 ELSE 0 END) AS HIDDEN null_order')
            ->orWhere('s.active >= 0')
            ->orWhere('s.active is null')
            ->addOrderBy('null_order', 'ASC') 
            ->addOrderBy('s.appearanceOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function filter(\App\Entity\SearchEntity\SecteurSearch $secteurSearch)
    {
        $queryBuilder = $this->createQueryBuilder('s')
         ->addSelect('(CASE WHEN s.appearanceOrder IS NULL THEN 1 ELSE 0 END) AS HIDDEN null_order');

        if (empty($_GET)) {
            $queryBuilder
            ->orWhere('s.active >= 0')
            ->orWhere('s.active is null');
        }

        if(!is_null($secteurSearch->getNom())) {
            $queryBuilder = $queryBuilder
                ->andWhere('s.nom LIKE :nom')
                ->setParameter('nom', '%'.$secteurSearch->getNom().'%');
        }

        if(!is_null($secteurSearch->getDescription())) {
            $queryBuilder = $queryBuilder
                ->andWhere('s.description LIKE :description')
                ->setParameter('description', '%'.$secteurSearch->getDescription().'%');
        }

        if(!is_null($secteurSearch->getEtat())) {
            $queryBuilder = $queryBuilder
                ->andWhere('s.active = :active')
                ->setParameter('active', $secteurSearch->getEtat());
        }
        $queryBuilder
            ->addOrderBy('null_order', 'ASC') 
            ->addOrderBy('s.appearanceOrder', 'ASC');


        return $queryBuilder->getQuery();
    }
}