<?php


namespace App\Controller;

use App\Entity\CoachSecteur;
use App\Entity\Secteur;
use App\Entity\User;
use App\Entity\Audit;
use App\Entity\Probleme;
use App\Form\AuditType;
use App\Form\UserLoginType;
use App\Manager\EntityManager;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Repository\ProblemeRepository;
use App\Services\AgentSecteurService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/admin/probleme")
*/
class AdminProblemeController extends AbstractController
{
    protected $repoUser;
    protected $problemeRepository;
    protected $entityManager;
    protected $userManager;


    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                ProblemeRepository $problemeRepository
                            )
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->problemeRepository = $problemeRepository;
    }

    /**
     * @Route("/{id}/liste", name="admin_probleme_list")
     */
    public function probleme_list(Audit $audit,Request $request, PaginatorInterface $paginator)
    {
       
        $probleme = $paginator->paginate(
            $this->problemeRepository->findBy(["audit" => $audit]),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/audit/list_audit.html.twig', [
            'probleme' => $probleme,
        ]);
    }

     /**
     * @Route("/{id}/view", name="admin_probleme_view")
     */
    public function audit_view(Probleme $probleme,Request $request, AgentSecteurService $agentSecteurService, PaginatorInterface $paginator)
    {
        
        return $this->render('user_category/admin/audit/view_audit.html.twig', [
            'probleme' =>$probleme
        ]);
    }

    /**
     * @Route("/{id}/add", name="admin_probleme_add")
     */
    public function admin_ambassadeur_add(Audit $audit,Request $request)
    {
        $audit = new Audit();
        $formUser = $this->createForm(AuditType::class, $audit)
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $audit->setDateAjout(new \DateTime());
            $audit->setPropriétaire($this->getUser());
            $this->entityManager->save($audit);

            $this->addFlash('success', "Nouvelle enregistrée avec succès");
            return $this->redirectToRoute('audit_view', ['id' =>  $audit->getId()]);    
        }

        return $this->render('user_category/admin/audit/add_audit.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Ajouter'
        ]);    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/edit", name="admin_audit_edit")
     */
    public function admin_ambassadeur_edit(Request $request, Audit $audit)
    {

        $formUser = $this->createForm(AuditType::class, $audit)
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->entityManager->save($audit);

            $this->addFlash('success', "modification effectuée avec succès");
            return $this->redirectToRoute('audit_view', ['id' =>  $audit->getId()]);    
        }

        return $this->render('user_category/admin/audit/add_audit.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Ajouter'
        ]);     
    }


    
   
}
