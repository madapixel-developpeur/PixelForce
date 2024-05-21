<?php


namespace App\Controller;

use App\Entity\Audit;
use App\Entity\Secteur;
use App\Form\AuditType;
use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Form\UserLoginType;
use App\Entity\CoachSecteur;
use App\Manager\UserManager;
use App\Manager\EntityManager;
use App\Repository\UserRepository;
use App\Services\AgentSecteurService;
use App\Repository\ReponseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Services\FileHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/reponse")
*/
class ReponseController extends AbstractController
{
    protected $repoUser;
    protected $reponseRepository;
    protected $entityManager;
    protected $userManager;
    protected $fileHandler;


    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                FileHandler $fileHandler,
                                ReponseRepository $reponseRepository
                            )
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->reponseRepository = $reponseRepository;
        $this->fileHandler = $fileHandler;
    }

    /**
     * @Route("/{id}/liste", name="admin_reponse_list")
     */
    public function reponse_list(Request $request, PaginatorInterface $paginator)
    {
       
        return $this->render('user_category/admin/audit/list_audit.html.twig', [
            //'reponse' => $reponse,
        ]);
    }

     /**
     * @Route("/{id}/view", name="reponse_view")
     */
    public function reponse_view(Reponse $reponse,Request $request, AgentSecteurService $agentSecteurService, PaginatorInterface $paginator)
    {     
        return $this->render('user_category/agent/reponse/view_reponse.html.twig', [
            'reponse' =>$reponse
        ]);
    }

    /**
     * @Route("/{id}/add", name="reponse_add")
     */
    public function admin_reponse_add(Audit $audit,Request $request)
    {
        $reponse = new Reponse();
        $formUser = $this->createForm(ReponseType::class, $reponse);
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $reponse->setAudit($audit);
            $reponse->setAuteur($this->getUser());
            $reponse->setIsActive(Reponse::ACTIVE_YES);
            $reponse->setDateAjout(new \DateTime());
            $fichier = $formUser->get('fichier')->getData();
            if ($fichier) {
                $fichier_nom = $this->fileHandler->upload($fichier, "reponse/fichier");
                $reponse->setFichier($fichier_nom);
            }
            $this->entityManager->save($reponse);

            $this->addFlash('success', "Nouvelle réponse enregistré avec succès");
            return $this->redirectToRoute('audit_view', ['id' =>  $audit->getId()]);    
        }

        return $this->render('user_category/agent/reponse/add_reponse.html.twig', [
            'formUser' => $formUser->createView(),
            'audit' => $audit,
            'button' => 'Ajouter'
        ]);    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/edit", name="reponse_edit")
     */
    public function admin_reponse_edit(Request $request,Reponse $reponse)
    {

        $formUser = $this->createForm(ReponseType::class, $reponse);
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $fichier = $formUser->get('fichier')->getData();
            if ($fichier) {
                $fichier_nom = $this->fileHandler->upload($fichier, "reponse/fichier");
                $reponse->setFichier($fichier_nom);
            }
            $this->entityManager->save($reponse);

            $this->addFlash('success', "Réponse mis à jour avec succès");
            return $this->redirectToRoute('audit_view', ['id' =>  $reponse->getAudit()->getId()]);    
        }

        return $this->render('user_category/agent/reponse/edit_reponse.html.twig', [
            'formUser' => $formUser->createView(),
            'audit' => $reponse->getAudit(),
            'button' => 'Modifier'
        ]);    
    }
    /**
     * @Route("/{id}/delete", name="reponse_delete")
     */
    public function admin_reponse_delete( Reponse $reponse)
    {
            $reponse->setIsActive(Reponse::ACTIVE_NO);
            $this->entityManager->save($reponse);
            $this->addFlash('success', "Suppression de la réponse effectuée avec succès");
            return $this->redirectToRoute('audit_view', ['id' => $reponse->getAudit()->getId()]);    
           
    }
    /**
     * @Route("/{id}/restaure", name="reponse_restore")
     */
    public function admin_reponse_restore( Reponse $reponse)
    {
            $reponse->setIsActive(Reponse::ACTIVE_YES);
            $this->entityManager->save($reponse);
            $this->addFlash('success', "Restoration de la réponse effectuée avec succès");
            return $this->redirectToRoute('audit_view', ['id' => $reponse->getAudit()->getId()]);    
           
    }

    /**
     * @Route("/{id}/download", name="reponse_download")
     */
    public function admin_reponse_download( Reponse $reponse)
    {
        if($reponse->getFichier()!=null)
            return $this->fileHandler->downloadFile($reponse->getFichier(),$reponse->getTitre());      
        else{
            $this->addFlash('danger', "aucun fichier detectée");
            return $this->redirectToRoute('reponse_view', ['id' => $reponse->getId()]);    
        }
    }


    
   
}
