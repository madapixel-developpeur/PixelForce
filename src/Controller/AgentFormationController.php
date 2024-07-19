<?php


namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Formation;
use App\Entity\FormationAgent;
use App\Manager\EntityManager;
use App\Services\MailerService;
use App\Repository\ContactRepository;
use App\Repository\SecteurRepository;
use App\Entity\CategorieFormationAgent;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AgentSecteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\FormationAgentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieFormationRepository;
use App\Services\CategorieFormationAgentService;
use App\Repository\RFormationCategorieRepository;
use App\Repository\CategorieFormationAgentRepository;
use App\Repository\FormationPageConfigurationRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgentFormationController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var FormationRepository
     */
    private $formationRepository;
    /**
     * @var FormationAgentRepository
     */
    private $formationAgentRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var SecteurRepository
     */
    private $secteurRepository;

    /** @var MailerService $mailerService; */
    private $mailerService;

    /** @var RFormationCategorieRepository $repoRelationFormationCategorie */
    protected $repoRelationFormationCategorie;
    
    /** @var CategorieFormationAgentService $categorieFormationAgentService */
    protected $categorieFormationAgentService;

    /** @var SessionInterface $sessionInterface */
    protected $sessionInterface;

    /** @var CategorieFormationRepository $repoCatFormation */
    protected $repoCatFormation;

    /** @var ContactRepository $repoContact */
    protected $repoContact;

    /** @var CategorieFormationAgentRepository $repoCategorieAgent */
    protected $repoCategorieAgent;

    public function __construct(EntityManager $entityManager, SecteurRepository $secteurRepository, PaginatorInterface $paginator, FormationRepository $formationRepository, FormationAgentRepository $formationAgentRepository, MailerService $mailerService, RFormationCategorieRepository $repoRelationFormationCategorie, CategorieFormationAgentService $categorieFormationAgentService, SessionInterface $sessionInterface, CategorieFormationRepository $repoCatFormation, ContactRepository $repoContact, CategorieFormationAgentRepository $repoCategorieAgent, private AgentSecteurRepository $agentSecteurRepository,
        private FormationPageConfigurationRepository $formationPageConfigurationRepository,
    )
    {
        $this->paginator = $paginator;
        $this->formationRepository = $formationRepository;
        $this->formationAgentRepository = $formationAgentRepository;
        $this->entityManager = $entityManager;
        $this->secteurRepository = $secteurRepository;
        $this->mailerService = $mailerService;
        $this->repoRelationFormationCategorie = $repoRelationFormationCategorie;
        $this->categorieFormationAgentService = $categorieFormationAgentService;
        $this->sessionInterface = $sessionInterface;
        $this->repoCatFormation = $repoCatFormation;
        $this->repoContact = $repoContact;
        $this->repoCategorieAgent = $repoCategorieAgent;
    }

    /**
     * @Route("/agent/formation/list", name="agent_formation_list", options={"expose"=true})
     * @IsGranted("ROLE_AGENT")
     */
    public function agent_formation_list(Request $request, SessionInterface $session)
    {
        // todo: miandry anle login agent izay ataon Tsiory mba haazaoana ilay session micontenir anle secteur
        $agent = $this->getUser();
        $secteur_id = $session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
        

        if($secteur) {
                        // dd($request->query->get('q'));
            $criteres = $request->query->get('q');
            $criteres = $criteres ? $criteres : [];
            $formations = $this->formationRepository->searchForAgent($criteres, $secteur);
            $agentSecteur = $this->agentSecteurRepository->findOneBy(["agent" => $agent, "secteur" => $secteur]);
            $formations = $this->paginator->paginate(
                $formations,
                $request->query->getInt('page', 1),
                20
            );
            // return $this->render('formation/video/agent_formation_list.html.twig', [
            //     'formations' => $formations,
            //     'criteres' => $criteres,
            //     'formationAgentRepository' => $this->formationAgentRepository,
            //     'categories' => $this->repoCatFormation->findBy(['statut' => 1]),
            //     'nbrAllMyContacts' => count($this->repoContact->findAll()),
            //     'agentSecteur' => $agentSecteur
            // ]);
            $configuration = $this->formationPageConfigurationRepository->findOneBy(['secteur'=> $secteur ]);
            return $this->render('formation/video/agent_detail_categorie_formation.html.twig', [
                'formations' => $formations,
                'criteres' => $criteres,
                'formationAgentRepository' => $this->formationAgentRepository,
                'categories' => $this->repoCatFormation->findBy(['statut' => 1]),
                'nbrAllMyContacts' => count($this->repoContact->findAll()),
                'agentSecteur' => $agentSecteur,
                'filesDirectory' => $this->getParameter('files_directory_relative'),
                'configuration' => $configuration,
            ]);
        }

        $this->addFlash('danger', 'Vous n\'avez pas renseigné le secteur');
        return $this->redirectToRoute('agent_accueil');
    }
    // public function agent_formation_list(Request $request, SessionInterface $session)
    // {
    //     // todo: miandry anle login agent izay ataon Tsiory mba haazaoana ilay session micontenir anle secteur
    //     $agent = $this->getUser();
    //     $allCategoriesOfAgent = $this->categorieFormationAgentService->getCategoriesFromFormationAgent($agent);
    //     $secteur_id = $session->get('secteurId');
    //     $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
    //     $categorie = $this->categorieFormationAgentService->getCurrentAgentCategorie($agent, $secteur);
        

    //     if($secteur) {
    //                     // dd($request->query->get('q'));
    //         if($criteres = $request->query->get('q')) {
    //             $formations = $this->formationRepository->searchForAgent($criteres, $secteur);
    //         } else {
    //             // $formations = $secteur ? $this->formationRepository->AgentfindBySecteur($secteur) : [];
    //             // $formations = $this->formationRepository->findFormationsAgentBySecteurAndCategorie($secteur, $agent, $categorie, false);
    //             $formations = $this->formationRepository->findFormationsAgentBySecteurAndCategorie($secteur, $agent, null, false);
    //         }

    //         $formations = $this->paginator->paginate(
    //             $formations,
    //             $request->query->getInt('page', 1),
    //             20
    //         );

    //         $categorie = $this->categorieFormationAgentService->getCurrentAgentCategorie($agent, $secteur);
    //         $formationsInCategory = $this->formationRepository->findFormationsAgentBySecteurAndCategorie($secteur, $agent, $categorie, true);
    //         if (count($formationsInCategory) > 0) {
    //             $firstFormation = $formationsInCategory[0];
    //         }else{
    //             $firstFormation = null;
    //         }            

    //         // dd($formationsInCategory);
    //         return $this->render('formation/video/agent_formation_list.html.twig', [
    //             'formations' => $formations,
    //             'criteres' => $criteres,
    //             'formationAgentRepository' => $this->formationAgentRepository,
    //             'categories' => $this->repoCatFormation->findBy(['statut' => 1]),
    //             'allCategoriesOfAgent' => $allCategoriesOfAgent,
    //             'nbrAllMyContacts' => count($this->repoContact->findAll()),
    //             'firstFormation' => $firstFormation
    //         ]);
    //     }

    //     $this->addFlash('danger', 'Vous \'avez pas renseigné le secteur');
    //     return $this->redirectToRoute('agent_accueil');
    // }

    /**
     * @Route("/agent/formation/fiche/{id}", name="agent_formation_fiche", options={"expose"=true})
     * @IsGranted("ROLE_AGENT")
     */
    public function coach_formation_fiche(Formation $formation, Request $request)
    {
       return $this->render('formation/video/agent_formation_fiche.html.twig', [
           'formation' => $formation,
           'formationAgentRepository' => $this->formationAgentRepository
       ]);
    }
    // public function coach_formation_fiche(Formation $formation, Request $request)
    // {
    //    return $this->render('formation/video/agent_formation_fiche.html.twig', [
    //        'formation' => $formation,
    //        'formationAgentRepository' => $this->formationAgentRepository
    //    ]);
    // }

    private function terminer_formation(Formation $formation, $quizData=[]){
        $agent = $this->getUser();
        $coach = $formation->getCoach();
        $agentSecteur = $this->agentSecteurRepository->findOneBy(["agent" => $agent, "secteur" => $formation->getSecteur()]);
        $result = $this->formationAgentRepository->findBy(['agent' => $agent, 'formation' => $formation]);
        $formationAgent = null;
        if(count($result) > 0){
            $formationAgent = $result[0];
        } else{
            $formationAgent = new FormationAgent();
            $formationAgent->setAgent($agent);
            $formationAgent->setFormation($formation);
        }
        $formationAgent->setStatut(Formation::STATUT_TERMINER);
        if($formation->getType() == Formation::TYPE_QUIZ){
            $score = isset($quizData['score']) ? $quizData['score'] : 0;
            $snapshot = isset($quizData['snapshot']) ? $quizData['snapshot'] : 0;
            $formationAgent->setLastResultScore($score);
            $formationAgent->setLastResultSnapshot($snapshot);
            if($formationAgent->getMaxResultScore() === null || $score >= $formationAgent->getMaxResultScore()){
                $formationAgent->setMaxResultScore($score);
                $formationAgent->setMaxResultSnapshot($snapshot);
            } 
            if($formationAgent->getMaxResultScore() < 50){
                $formationAgent->setStatut(Formation::STATUT_IN_PROGRESS);
            }
        }
        
        $this->entityManager->persist($formationAgent);
        if($formationAgent->getStatut() === Formation::STATUT_TERMINER){
            $formationRank = $formation->getCategorieFormation()->getOrdreCatFormation();
            if(count($this->formationRepository->getNextFormationsByCategorieAndSecteur($formation->getSecteur(), $formation->getCategorieFormation(), $formation->getId(), $formation->getType())) == 0){
                $formationRank ++;
            }

            if($agentSecteur->getCurrentFormationRank() < $formationRank){
                $agentSecteur->setCurrentFormationRank($formationRank);
                $this->entityManager->persist($agentSecteur);
            }
        }
        
        $this->entityManager->flush();
        return $formationAgent;
    }
    /**
     * @Route("/agent/formation/terminer/{id}", name="agent_formation_terminer", options={"expose"=true})
     * @IsGranted("ROLE_AGENT")
     */
    public function coach_formation_terminer(Formation $formation, Request $request)
    {
        try{
            $this->terminer_formation($formation);
            // $this->mailerService->sendMailAfterDoneFormation($agent, $coach, $formation);
            $this->addFlash('congratulation_message', 'Vous venez de terminer la formation : '.$formation->getTitre());
        } catch(Exception $ex){
            $this->addFlash('danger', $ex->getMessage());
        }
        
        if (isset($_GET['path'] ) and $_GET['path'] === 'fromDashboard') {
            // On redirige l'utilisateur vers le dashbord lorsqu'il a cliquer le bouton 'J'ai terminé la formation' depuis le dashboard
            $secteur_id = $this->sessionInterface->get('secteurId');
            return $this->redirectToRoute('agent_dashboard_secteur', ['id' => $secteur_id]);
        } else {
            return $this->redirectToRoute('agent_formation_list');
        }
        
    }
    // public function coach_formation_terminer(Formation $formation, Request $request)
    // {
    //     $agentCategorie = new CategorieFormationAgent();
    //     $agent = $this->getUser();
    //     $coach = $formation->getCoach();
    //     $formationAgentRelation = $this->formationAgentRepository->findOneBy(['formation' => $formation, 'agent' => $this->getUser()]);
    //     if($formationAgentRelation) {
    //         $formationAgentRelation->setStatut(Formation::STATUT_TERMINER);
    //         $this->entityManager->save($formationAgentRelation);
    //     }

    //     $agentCategories = $this->categorieFormationAgentService->getAllAgentCategories($agent);
    //     $categorie = $formation->getCategorieFormation();
    //     $isCategoryAlreadyExisting =  $this->categorieFormationAgentService->isCategoryAlreadyExisting($agentCategories, $categorie);
    //     // dd($isCategoryAlreadyExisting);
    //     if (!$isCategoryAlreadyExisting) {
    //         $agentCategorie->setAgent($agent);
    //         $agentCategorie->setCategorieFormation($categorie);
    //         $this->entityManager->save($agentCategorie);
    //     }

    //     $this->mailerService->sendMailAfterDoneFormation($agent, $coach, $formation);
    //     $this->addFlash('success', '<h2 class="text-secondary text-center"> 🎉 Félicitations! Vous venez de terminer la formation : '.$formation->getTitre().' 🎉</h2>');
        
    //     if (isset($_GET['path'] ) and $_GET['path'] === 'fromDashboard') {
    //         // On redirige l'utilisateur vers le dashbord lorsqu'il a cliquer le bouton 'J'ai terminé la formation' depuis le dashboard
    //         $secteur_id = $this->sessionInterface->get('secteurId');
    //         return $this->redirectToRoute('agent_dashboard_secteur', ['id' => $secteur_id]);
    //     } else {
    //         return $this->redirectToRoute('agent_formation_list');
    //     }
        
    // }

    /**
     * @Route("/agent/quiz/{id}/commencer", name="agent_quiz_begin", options={"expose"=true})
     * @IsGranted("ROLE_AGENT")
     */
    public function quiz_begin(Formation $quiz, Request $request)
    {
        if ($request->isMethod('POST')) {
            try{

            
                // Handle the POST request
                $result = $request->get('quizResult');
                $result = $result ? json_decode($result, true) : [];
                $countItem = 0;
                $countItemTrue = 0;
                $snapshot = [
                    'titre' => $quiz->getTitre(),
                    'description' => $quiz->getDescription(),
                    'categorie' => $quiz->getCategorieFormation()?->getNom()??'',
                    'items' => []
                ];
                foreach ($quiz->getValidFormationQuizItems() as $item) {
                    $itemResult = isset($result[$item->getId()]) ? $result[$item->getId()] : [];
                    $choices = $item->getValidFormationQuizItemChoices();
                    $wrongCount = 0;
                    $itemSnapshot = [
                        'question' => $item->getQuestion(),
                        'multipleChoix' => $item->isMultipleChoix(),
                        'choices' => [],
                        'result' => true,
                        'wrongCount' => 0
                    ];
                    foreach ($choices as $choice) {
                        $checked = in_array($choice->getId(), $itemResult);
                        if($checked !== ($choice->isVrai()??false)) $wrongCount++;
                        $itemSnapshot['choices'][] = [
                            'choix' => $choice->getChoix(),
                            'vrai' => $choice->isVrai(),
                            'checked' => $checked
                        ];
                    }
                    $countItem++;
                    if($wrongCount > 0){
                        $itemSnapshot['result'] = false;
                        $itemSnapshot['wrongCount'] = $wrongCount;
                    } else {
                        $countItemTrue++;
                    }
                    $snapshot['items'][] = $itemSnapshot;
                    
                }
                $score = $countItemTrue * 100./$countItem;

                $formationAgent = $this->terminer_formation($quiz, ['score' => $score, 'snapshot' => $snapshot]);
                $this->addFlash('success', '<h2 class="text-secondary text-center"> 🎉 Félicitations! Vous venez de terminer le quiz : '.$quiz->getTitre().' 🎉</h2>');
                return $this->redirectToRoute('agent_quiz_result', ['id' => $formationAgent->getId()]);
            } catch(Exception $ex){
                $this->addFlash('danger', $ex->getMessage());
            }
        }
       return $this->render('formation/quiz/agent_quiz_begin.html.twig', [
           'quiz' => $quiz,
       ]);
    }

    /**
     * @Route("/agent/quiz/{id}/result", name="agent_quiz_result", options={"expose"=true})
     * @IsGranted("ROLE_AGENT")
     */
    public function quiz_result(FormationAgent $result, Request $request)
    {
        
       return $this->render('formation/quiz/agent_quiz_result.html.twig', [
           'result' => $result,
       ]);
    }

       /**
     * @Route("/agent/video-secteur/terminer", name="agent_video_secteur_terminer", options={"expose"=true})
     * @IsGranted("ROLE_AGENT")
     */
    public function video_secteur_terminer(Request $request)
    {
        try{
           $agent  = $this->getUser();
           $agent->setHaveSeenSectorVideo(User::HAVE_SEEN_SECTOR_VIDEO);
           $this->entityManager->persist($agent);
           $this->entityManager->flush();
            $this->addFlash('congratulation_message', "Félicitations ! Vous venez de terminer la première vidéo de présentation de Pixelforce. Vous pouvez maintenant choisir le secteur qui vous convient.");
        } catch(Exception $ex){
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('agent_home');
        
    }

     /**
     * @Route("/agent/formation/detail/categorie-formation", name="agent_formation_categorie_detail", options={"expose"=true})
     * @IsGranted("ROLE_AGENT")
     */
    public function categorie_formation_fiche(Request $request)
    {
       return $this->render('formation/video/agent_detail_categorie_formation.html.twig', [
          
       ]);
    }
}