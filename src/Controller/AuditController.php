<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Audit;
use App\Form\UserType;
use App\Entity\Secteur;
use App\Form\AuditType;
use App\Form\UserLoginType;
use App\Entity\CoachSecteur;
use App\Manager\UserManager;
use App\Form\CoachSecteurType;
use App\Manager\EntityManager;
use App\Services\AuditService;
use App\Repository\UserRepository;
use App\Repository\AuditRepository;
use App\Repository\SecteurRepository;
use App\Services\AgentSecteurService;
use App\Entity\SearchEntity\UserSearch;
use App\Repository\CoachAgentRepository;
use App\Repository\CoachSecteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/audit")
*/
class AuditController extends AbstractController
{
    protected $repoUser;
    protected $auditRepository;
    protected $entityManager;
    protected $userManager;

    protected $repoCoachAgent;

    protected $repoSecteur;
    protected $auditService;
    protected $repoCoachSecteur;

    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                CoachAgentRepository $repoCoachAgent,
                                SecteurRepository $repoSecteur,
                                AuditRepository $auditRepository,
                                AuditService $auditService,
                                CoachSecteurRepository $repoCoachSecteur)
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->repoCoachAgent = $repoCoachAgent;
        $this->repoSecteur = $repoSecteur;
        $this->auditRepository = $auditRepository;
        $this->repoCoachSecteur = $repoCoachSecteur;
        $this->auditService = $auditService;
    }

    /**
     * @Route("/liste", name="audit_list")
     */
    public function audit_list(Request $request, PaginatorInterface $paginator)
    {
        $user=$this->getUser();
       
        $audit = $paginator->paginate(
            $this->auditService->findAudit($user),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/agent/audit/list_audit.html.twig', [
            'audits' => $audit,
        ]);
    }

     /**
     * @Route("/{id}/view", name="audit_view")
     */
    public function audit_view(Audit $audit,Request $request, AgentSecteurService $agentSecteurService, PaginatorInterface $paginator)
    {
        
        return $this->render('user_category/agent/audit/view_audit.html.twig', [
            'audit' =>$audit
        ]);
    }

    /**
     * @Route("/add", name="audit_add")
     */
    public function admin_ambassadeur_add(Request $request)
    {
        $audit = new Audit();

        $formUser = $this->createForm(AuditType::class, $audit)
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $audit->setDateAjout(new \DateTime());
            $audit->setIsActive(Audit::ACTIVE_YES);
            $audit->setPropriétaire($this->getUser());
            $this->entityManager->save($audit);

            $this->addFlash('success', "Nouvel Audit enregistrée avec succès");
            return $this->redirectToRoute('audit_view', ['id' =>  $audit->getId()]);    
        }

        return $this->render('user_category/agent/audit/add_audit.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Ajouter'
        ]);    
    }

    /**
     * @Route("/{id}/edit", name="audit_edit")
     */
    public function admin_ambassadeur_edit(Request $request, Audit $audit)
    {

        $formUser = $this->createForm(AuditType::class, $audit)
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->entityManager->save($audit);

            $this->addFlash('success', "Modification Audit effectuée avec succès");
            return $this->redirectToRoute('audit_view', ['id' =>  $audit->getId()]);    
        }

        return $this->render('user_category/agent/audit/edit_audit.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Modifier'
        ]);     
    }

    /**
     * @Route("/{id}/delete", name="audit_delete")
     */
    public function admin_audit_delete(Request $request, Audit $audit)
    {
            $audit->setIsActive(Audit::ACTIVE_NO);
            $this->entityManager->save($audit);
            $this->addFlash('success', "Suppression Audit effectuée avec succès");
            return $this->redirectToRoute('audit_list');    
           
    }
    /**
     * @Route("/{id}/restore", name="audit_restore")
     */
    public function admin_restore_delete(Request $request, Audit $audit)
    {
            $audit->setIsActive(Audit::ACTIVE_YES);
            $this->entityManager->save($audit);
            $this->addFlash('success', "Restoration Audit effectuée avec succès");
            return $this->redirectToRoute('audit_list');    
           
    }

   
}
