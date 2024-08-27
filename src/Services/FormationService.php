<?php


namespace App\Services;


use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\Formation;
use App\Entity\FormationAgent;
use App\Manager\EntityManager;
use App\Manager\ObjectManager;
use App\Entity\CategorieFormation;
use App\Repository\FormationRepository;
use App\Repository\AgentSecteurRepository;

class FormationService
{
    /**
     * @var ObjectManager
     */
    private $objectManager;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /** @var FormationRepository $repoFormation */
    protected $repoFormation;

    public function __construct(ObjectManager $objectManager, EntityManager $entityManager, FormationRepository $repoFormation)
    {
        $this->objectManager = $objectManager;
        $this->entityManager = $entityManager;
        $this->repoFormation = $repoFormation;
    }

    public function affecterAgent(Formation $formation, User $agent, $onlyPersist = false)
    {
       return $this->objectManager->createObject(FormationAgent::class, [
            'agent' => $agent,
            'formation' => $formation,
            'statut' => $formation->getDebloqueAgent() ? Formation::STATUT_DISPONIBLE : Formation::STATUT_BLOQUEE,
        ], false, [], $onlyPersist);
    }

    public function affecterToutAgent(Formation $formation, Secteur $secteur)
    {
        $agents = $secteur->getAgents();
        foreach($agents as $agent) {
            $this->affecterAgent($formation, $agent, true);
        }
        $this->entityManager->flush();
    }

    public function affecterToutFormation(User $agent, Secteur $secteur)
    {
        $formations = $secteur->getFormations();
        foreach($formations as $formation) {
            $this->affecterAgent($formation, $agent, true);
        }
        $this->entityManager->flush();
    }

    public function deleteMedia()
    {

    }

    /**
     * Permet de récupérer les catégories dans les formations d'un coach
     *
     * @param User $coach
     */
    public function getCoachCategoriesInFormation(User $coach)
    {
        $formations = [];
        $categories = [];
        $formationsCoach = $this->repoFormation->findBy(['coach'=> $coach]);
        foreach ($formationsCoach as $formation) {
            if ($formation->getCategorieFormation()) {
                $categories[] = $formation->getCategorieFormation();
            }
        }
        $categories = array_unique($categories, SORT_REGULAR);
        
        return $categories;
    }

    public function getRendezVousFormation(Secteur $secteur, int $formationId = null,CategorieFormation $categorie = null){
        $formation = null;
        if(is_null($categorie)){
            return [
                'formation' => null,
                'previous' => null,
                'next' => null,
            ];
        }
        if($formationId){
            $formation = $this->repoFormation->findOneBy(['id' => $formationId]);
        }
        else{
            $formation= $this->repoFormation->getSingleFormationByCategorie($secteur,$categorie);
        }

        if(is_null($formation)){
            return [
                'formation' => null,
                'previous' => null,
                'next' => null,
            ];
        }

        $data['formation'] = $formation;
        $data['previous'] = $this->repoFormation->getSingleFormationByCategorie($secteur,$categorie,['current' => $formation , 'previous' => true ]);
        $data['next']  = $this->repoFormation->getSingleFormationByCategorie($secteur,$categorie,['current' => $formation , 'next' => true ]);
        return $data;
    }
}