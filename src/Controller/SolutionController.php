<?php


namespace App\Controller;

use App\Entity\Audit;
use App\Entity\Probleme;
use App\Entity\Solution;
use App\Form\SolutionType;
use App\Manager\UserManager;
use App\Services\FileHandler;
use App\Manager\EntityManager;
use App\Repository\UserRepository;
use App\Services\AgentSecteurService;
use App\Repository\ProblemeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/solution")
*/
class SolutionController extends AbstractController
{
    protected $repoUser;
    protected $problemeRepository;
    protected $entityManager;
    protected $userManager;
    protected $fileHandler;


    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                FileHandler $fileHandler,
                                ProblemeRepository $problemeRepository
                            )
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->problemeRepository = $problemeRepository;
        $this->fileHandler = $fileHandler;
    }

    /**
     * @Route("/{id}/liste", name="admin_probleme_list")
     */
    public function probleme_list(Audit $audi,Request $request, PaginatorInterface $paginator)
    {
       
        return $this->render('user_category/admin/audit/list_audit.html.twig', [
            //'probleme' => $probleme,
        ]);
    }

     /**
     * @Route("/{id}/view", name="solution_view")
     */
    public function solution_view(Solution $probleme,Request $request, AgentSecteurService $agentSecteurService, PaginatorInterface $paginator)
    {     
        return $this->render('user_category/agent/solution/view_solution.html.twig', [
            'solution' =>$probleme
        ]);
    }

    /**
     * @Route("/{id}/add", name="solution_add")
     */
    public function admin_solution_add(Probleme $probleme,Request $request)
    {
        $solution = new Solution();
        $formUser = $this->createForm(SolutionType::class, $solution);
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $solution->setProbleme($probleme);
            $solution->setStatus(Solution::STATUS_VERIFIED);
            $solution->setIsActive(Solution::ACTIVE_YES);
            $fichier = $formUser->get('fichier')->getData();
            if ($fichier) {
                $fichier_nom = $this->fileHandler->upload($fichier, "solution/fichier");
                $solution->setFichier($fichier_nom);
            }
            $this->entityManager->save($solution);

            $this->addFlash('success', "Nouvelle solution enregistrée avec succès");
            return $this->redirectToRoute('probleme_view', ['id' =>  $probleme->getId()]);    
        }

        return $this->render('user_category/agent/solution/add_solution.html.twig', [
            'formUser' => $formUser->createView(),
            'probleme' => $probleme,
            'button' => 'Ajouter'
        ]);    
    }

    /**
     * @Route("/{id}/edit", name="solution_edit")
     */
    public function admin_solution_edit(Request $request,Solution $solution)
    {
        $formUser = $this->createForm(SolutionType::class, $solution);
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $fichier = $formUser->get('fichier')->getData();
            if ($fichier) {
                $fichier_nom = $this->fileHandler->upload($fichier, "solution/fichier");
                $solution->setFichier($fichier_nom);
            }
            $this->entityManager->save($solution);
            $this->addFlash('success', "Solution mis à jour avec succès");
            return $this->redirectToRoute('probleme_view', ['id' =>  $solution->getProbleme()->getId()]);;    
        }

        return $this->render('user_category/agent/solution/edit_solution.html.twig', [
            'formUser' => $formUser->createView(),
            'probleme' => $solution->getProbleme(),
            'button' => 'Modifier'
        ]);  
    }

    /**
     * @Route("/{id}/delete", name="solution_delete")
     */
    public function admin_solution_delete( Solution $solution)
    {
            $solution->setIsActive(Solution::ACTIVE_NO);
            $this->entityManager->save($solution);
            $this->addFlash('success', "Suppression Solution effectuée avec succès");
            return $this->redirectToRoute('probleme_view', ['id' => $solution->getProbleme()->getId()]);    
           
    }

    /**
     * @Route("/{id}/restore", name="solution_restore")
     */
    public function admin_solution_restore( Solution $solution)
    {
            $solution->setIsActive(Solution::ACTIVE_YES);
            $this->entityManager->save($solution);
            $this->addFlash('success', "Restoration Solution effectuée avec succès");
            return $this->redirectToRoute('probleme_view', ['id' => $solution->getProbleme()->getId()]);    
           
    }

     /**
     * @Route("/{id}/download", name="solution_download")
     */
    public function admin_solution_download( Solution $solution)
    {
        if($solution->getFichier()!=null)
            return $this->fileHandler->downloadFile($solution->getFichier(),$solution->getTitre());      
        else{
            $this->addFlash('danger', "aucun fichier detectée");
            return $this->redirectToRoute('solution_view', ['id' => $solution->getId()]);    
        }
    }
   
}
