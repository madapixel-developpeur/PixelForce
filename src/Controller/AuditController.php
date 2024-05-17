<?php


namespace App\Controller;

use App\Entity\Audit;
use App\Entity\Meeting;
use App\Form\AuditType;
use App\Manager\UserManager;
use App\Manager\EntityManager;
use App\Services\AuditService;
use App\Repository\UserRepository;
use App\Repository\AuditRepository;
use App\Repository\SecteurRepository;
use App\Services\AgentSecteurService;
use App\Repository\CoachAgentRepository;
use App\Repository\CoachSecteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    protected $session;

    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                CoachAgentRepository $repoCoachAgent,
                                SecteurRepository $repoSecteur,
                                AuditRepository $auditRepository,
                                AuditService $auditService,
                                SessionInterface $session,
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
        $this->session = $session;

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
    public function admin_audit_add(Request $request)
    {
        return $this->add_audit($request); 
    }
    /**
     * @Route("/meeting/{id}/add", name="meeting_audit_add")
     */
    public function admin_audit_meeting_add(Request $request,Meeting $meeting)
    {
            return $this->add_audit($request,$meeting);
    }

    function add_audit(Request $request,Meeting $meeting=null) {
        $audit = new Audit();

        $formUser = $this->createForm(AuditType::class, $audit)
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $secteur_id=$this->session->get('secteurId');
            $secteur=$this->repoSecteur->findOneBy(['id' => $secteur_id]);
            if($secteur){
                $audit->setSecteur($secteur);
            }
            $audit->setDateAjout(new \DateTime());
            $audit->setIsActive(Audit::ACTIVE_YES);
            $audit->setPropriétaire($this->getUser());
            $this->entityManager->save($audit);
            
            if($meeting!=null) {
                $meeting->setAudit($audit);
                $this->entityManager->save($meeting);
                $googleForm=$audit->getSecteur()->getGoogleForms();
                $this->addFlash(
                    'success',
                    "Nouvel Audit Enregistré,veuillez visualiser la fiche de votre rendez-vous"
                 );    
                 return $this->redirectToRoute('agent_contact_meeting_fiche',['id'=>$meeting->getId()]);
            }
            else {
                $this->addFlash('success', "Nouvel Audit enregistrée avec succès");
                return $this->redirectToRoute('audit_view', ['id' =>  $audit->getId()]);
            }
    
        }

        return $this->render('user_category/agent/audit/add_audit.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Ajouter'
        ]); 
    }

    /**
     * @Route("/{id}/edit", name="audit_edit")
     */
    public function admin_audit_edit(Request $request, Audit $audit)
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
